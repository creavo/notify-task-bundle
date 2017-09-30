# CREAVO TaskNotifyBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3837f1b6-1308-4b63-9b68-01e9458fa3bf/mini.png)](https://insight.sensiolabs.com/projects/3837f1b6-1308-4b63-9b68-01e9458fa3bf)
[![Packagist](https://img.shields.io/packagist/dt/creavo/notify-task-bundle.svg)](https://packagist.org/packages/creavo/notify-task-bundle)

### Installation

    composer require creavo/notify-task-bundle
    
Add the bundle to your `app/AppKernel.php` with 

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = [
                [...],
                new Creavo\NotifyTaskBundle\CreavoNotifyTaskBundle(),
            ];
            
            return $bundles;
        }
        
        [...]
    }

register routing in `routing.yml`:

    notify_task:
        resource: '@CreavoNotifyTaskBundle/Resources/config/routing.xml'
        prefix: /task-notify

Update the doctrine-schema - use 

    php bin/console doctrine:schema:update

or do a migration:

    php bin/console doctrine:migration:diff
    php bin/console doctrine:migration:migrate
    

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
    
    // create notification
    $notification=$this->get('creavo_notify_task.notification')->create($user, 'this is the message', 'optional title', $relatedEntity);
    
    // maybe modify notification further
    $notification->setLinkTitle('Test');
    
    // save it
    $this->get('creavo_notify_task.notification')->save($nofitication);
    
    // you can also save it with $em directly, but this will not trigger pushover or email-notification
    $em->persist($notification);
    $em->flush();
