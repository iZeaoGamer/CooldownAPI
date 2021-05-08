<?php 
namespace Zeao\cooldown;


use pocketmine\Player;

final class API{

    protected static array $cooldown = [];
    
    
/** Returns if the cooldown for the user is active. Returns true if active, returns false if not.
 * @param Player $player 
 * @param int $time = 2 (Time you'd like the cooldown to be.)
 * @return bool
*/
static function hasCooldownTime(Player $player, int $time = 2): bool{
        return((time() - self::$cooldown[$player->getLowerCaseName()]) < $time);
}

/** Builds a item construction, and returns a useable value.
 * Return true if the item is useable. Returns false if the item cannot be used.
 * @param Player $player 
 * @param bool $reset = false (Returns whether or not the timer should be reset.)
 * continue; ^^ Can be used for being able to use this function multiple times where possible.
 * 
 * @return bool
 */
static function canUseItem(Player $player, bool $reset = false): bool{
    $use = true;
    if(self::isCooldownActive($player)){
        if(self::hasCooldownTime($player)){
            $use = false;
        }else{
            $use = true;
            if($reset){
            self::setCooldownTime($player);
            }
        }
    }else{
        $use = true;
        if($reset){
        self::setCooldownTime($player);
        }
    }
    return $use;
}

/** Sets the time() unix timestamp, making it useable again upon next action. */
/** @param Player $player
 * @return void
 */
static function setCooldownTime(Player $player): void{
        self::$cooldown[$player->getLowerCaseName()] = time();
}
}
