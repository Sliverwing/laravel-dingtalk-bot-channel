# Laravel Dingtalk Bot Channel  

> add dingtalk bot channel support for Laravel 

## Message Type Supported  

- [x] Text  
- [x] Link  
- [x] Markdown  
- [x] ActionCard  
- [] FeedCard  

## Usage  

* Require this package  

```bash
composer require sliverwing/laravel-dingtalk-bot-channel
```

* Add configuration file to your project  

```php

# ./config/dingtalk.php
return [
    'bot' => [
        'token' => 'Your Token'
    ]
];

```

* Update your notification file  

```php

    // ...

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DingtalkBotChannel::class];
    }
    
    // ...
    
    public function toDingTalkBot($notifiable)
    {
        return (new Message())
            ->text("Test Msg")
            ->at(['156xxxx8827', '189xxxx8325'], false);
    }
    
    // ...
        

```

