# CREAVO TaskNotifyBundle

### Installation

add the following to your composer.json:

    "repositories": [
        {
            "type": "vcs",
            "url": "git@bitbucket.org:creavo/notify-task-bundle.git"
        }
    ],

then run:

    composer require creavo/notify-task-bundle "dev-master"
    
add bundle to your `app/AppKernel.php`:

    new Creavo\NotifyTaskBundle\CreavoNotifyTaskBundle(),
    
register routing in `routing.yml`:


### configuration

add to your `config.yml` and adjust to your wishes:

    creavo_notify_task:
        send_notification_immediately: true
        pushover_enabled: false
        pushover_api_token: YOUR_PUSHOVER_APP_TOKEN
        email_enabled: false
        email_from: symfony@localhost
        email_subject: new notification
 
### usage

create notification:
    
    $this->get('creavo_notify_task.notification')->createNotification($user, 'this is the message', 'optional title', $relatedEntity);
    
