# CREAVO TaskNotifyBundle

### Installation

add the following to your composer.json:


then run:

    composer require creavo/task-notify-bundle "dev-master"
    
add bundle to your `app/AppKernel.php`:

    new Creavo\NotifyTaskBundle\CreavoNotifyTaskBundle(),
    
register routing in `routing.yml`:


### configuration

add to your `config.yml`:

    creavo_notify_task:
        pushover_api_token: YOUR_PUSHOVER_APP_TOKEN
 
### usage

create notification:
    
    $this->get('creavo_notify_task.notification')->createNotification($user, 'this is the message', 'optional title', $relatedEntity);
    
