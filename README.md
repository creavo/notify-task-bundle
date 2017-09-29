# CREAVO TaskNotifyBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3837f1b6-1308-4b63-9b68-01e9458fa3bf/mini.png)](https://insight.sensiolabs.com/projects/3837f1b6-1308-4b63-9b68-01e9458fa3bf)
[![Packagist](https://img.shields.io/packagist/dt/creavo/notify-task-bundle.svg)](https://packagist.org/packages/creavo/notify-task-bundle)

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
    
