# CREAVO TaskNotifyBundle

### Installation

    composer require creavo/notify-task-bundle
    
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
    
