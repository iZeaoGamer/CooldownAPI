## An API for Cooldowns.

## With this API, you can also fix Player interaction bugs upon execution / action of player interaction.

## API Logics

First, you may need to use the following imports if not set already:

```php
use pocketmine\Player;
use Zeao\cooldown\API;
use pocketmine\scheduler\ClosureTask; 
```

Thanks to our API Logics, you can check if a cooldown already has a timer.

```php
API::hasCooldownTime(Player $playerToActivateOn, int $timeSet): bool{
```

We do indeed support multiple functions, per class. Though, it may be difficult, it is possible.

Now, there is a couple of ways of doing this.

1. Using Scheduler tasks

If you want to later on register your event listener, which has the cooldown checks, you can do so!

```php
$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function(): void{
$this->getServer()->getPluginManager()->registerEvents(new ClassListener($constructor), $pluginClass);
}), 20 * 2); 
```

Now, to the fun part - Making event listeners have a cooldown per.

```php
<?php
namespace Zeao\cooldown;

use pocketmine\event\Listener;
use Zeao\cooldown\API;
use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent; //our main cause of interaction spams.
class ClassListener implements Listener{

public Plugin $plugin;
    public function __construct(Plugin $pluginClass){
        $this->plugin = $pluginClass;

public function onSpam(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    if(!API::canUseItem($player)){
        $event->setCancelled(true);
    }
    //now if you want to set multiple functions in one, you can do this:
      if(API::canUseItem($player)){
            if(API::canUseItem($player, true)){
         
             $this->plugin->getLogger()->debug("Interaction spam test = Reset timer turned on.");
        }
        $this->plugin->getLogger()->debug("Interaction spam test = Reset timer turned off.");
    }
        

```

Let me run through the things that are in this code.

$reset, if it returns true in canUseItem(), it'll reset the timer.

If it returns false, it won't reset the timer.

If you want to add it in the same class, you've gotta add 
```php
if(API::canUseItem(Player $player)){ 
```

Because the last function actually counts after the first one, you will need to use:
```php 
if(API::canUseItem(Player $player, true)){

```

This function must be used after the first function with reset false occurs.

Another way to do it, is by saperating each class, and making one class it doesn't reset the timer, and the other, it resets the timer. Use the following:

```php
$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function(): void{
    $this->getServer()->getPluginManager()->registerEvents(new CooldownWithoutReset(), $this);
$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function(): void{
    $this->getServer()->getPluginManager()->registerEvents(new CooldownWithReset(), $this);
}), 20 * 1);
}), 20 * 1);

```

## NOTE

This is not a plugin. It's a simple virion, to actually put into your plugins or in a specific folder where your plugin is kept.

## How to install

You can inject the virion into your own plugins or use a plugin's source code, if you wish!

You can install it into your plugins, by using poggit.yml.

```yml
libs:
  - src: Zeao/cooldown/API
    version: ~1.0.0
```

If you have any issues with our current API, please be sure to open an github issue!


