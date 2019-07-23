# Mailman V1.0

### Purpose
The system should provide an API to allow application servers to traffic transaction mail with a high degree of certainty.

The system should allow for backup service providers to bubble to the top should the primary provider go down for any reason.

### How would the system work?
There would be 3 basic services. 

One to accept the emails and store them both in the DB and on the queue.  The caller is provided a unique ID for the email accepted.  This is stored with the email in the DB as well 
as included as a custom field with the queued job, to later be passed to the provides as a custom field, so that when it comes back via webhooks we can identify the exact trail.

The second service would pick up the emails from the queue and deliver to the main provider. We would monitor failure and exceptions counts in the db and hot swap in a new provider should 
we encounter a threshold of failures.  Once the new provider was in place we would process the failed jobs again.
In the meantime a scheduled job would monitor the primary service until back up and we would hotswap back.

The third service would only process callbacks/webhooks from the providers and log the events as relationships to the original email, so we would have an audit trail.

### How is the system designed?

I have designed the system to be horizontally scalable using load balanced Docker containers on a single node for this assigment as the spec mentioned no extra installs beyond Docker. 
I have segmented the responsibilities into a few microservices and have planned to have a few Lumen instances (specifically due to it being lightweight and less resource hungry than laravel) 
we could have more services running on the same resources. I had called this repo 'monorepo' as it would house all the individual service sites as well as the Docker composition 
to make it easy for you guys to pull and build in one go.   But on closer inspection, there would be needless duplication of models, migrations etc and it makes more sense to just stand up 
various clones that perform different tasks.  So currently there is only one Lumen site called MailMan and a set of docker config files.

So in the docker-composer.yaml file we have:

##### db - MySql 5.7
This container houses MySql and acts as the central store for the queue jobs as well as the audit log of the emails sent.

##### acceptorApp - PHP 7.2-fpm & acceptorServer - Nginx
This pair provide the endpoint for accepting emails to be trafficked. They accept the email, inject it in the database and place it on the queue
with a priority (password reset - high, invoices - low, etc). You can also access a simple Vue admin interface to send a sample email as well as push the 
Ngrok tunnel URL to the service provider as the target for the webhooks.

Admin https://127.0.0.1:8080/admin   (no doubt 80 is taken on your machines.)

##### loadBalancer - HA Proxy
in order to have the traffic spread across the containers a simple HA Proxy sites in front of the Acceptor (takes in messages via HTTP API as well as delivering the VUE app.)

##### processorApp - PHP 7.2-fpm
This container does not have a http server attached as it only needs to process the queue and send the emails to the designated provider. This container has SupervisorD running to ensure
the queue:work is always up.

##### webhookApp - PHP 7.2-fpm (not built)
These container were never built, they would service only callbacks from the providers and currently acceptorApp/acceptorServer were standing in.

##### ngrok - Tunneler
Due to the fact that you will stand this system up on your laptop and no doubt be behind a firewall, we need some way to tunnel the webhook callbacks to your machine.

### Step to run the containers.

N.B. I have left the .env with keys in place for ease, obviously this would be vault driven etc.

1. Clone the repo.
2. Run npm install and composer update in the mailman folder (not the root).
3. Build and launch the services:   docker-compose up  --build -d --scale acceptorApp=2 --scale processorApp=2 
4. After a long build, give the system a min or two to start MySql and then run: docker-compose exec acceptorApp php artisan migrate --seed  (if it fails try after a minute)
5. Browser to https://127.0.0.1:8080/admin (no auth anywhere as directed)
6. Browse to Webhooks and follow the link to https://127.0.0.1:4040 .. this should give you your tunnel url, use this in the Admin and update. The url will be pushed to Sendgrid.
7. Browse to Send a Message and send away.

#### The BAD news.
This has been huge challenge for me as I my primary audience are generally SME's and deployment to a single server possibly 2 is adequate. I have never used Docker as mentioned so have had to learn from scratch.
I have been working on this assignment in the evenings/weekends over the last 2 weeks as I currently have 2 huge deadlines in play and have spent every spare moment on it. I have arrived at the point where I cannot work on it any more 
, no matter how much I want to, due to the deadlines that are this week and next. I usually just get the code working before going in and refactoring to make injectable contracts and bulletproof validations etc before I do an initial clean commit. So as a result the system is far from complete,
there is just no time. I think even if I worked on it full time for two weeks it would be a stretch to get perfect.

So it's with a very heavy heart that it is incomplete, with no failover, tests, micro commits or a CLI app.  I understand that this constitutes failure to deliver on the requirement and no doubt precludes me from the position.

I have learned an inordinate amount and would like to thank you guys very much for the opportunity. It would be fantastic if you would take a look anyway and provide some feedback.
