<?php

/**
 * @author Michael Fenwick <mike@mikefenwick.com>
 * @version 1.0
 * Abstract Singleton class for PHP.  Extending classes must define a protected static $instance member.
 */
abstract class Singleton {
    /** @var Singleton The singleton instance stored by the class. Singleton::$instance doesn't actually store any values itself. It just exists as a reminder that extending classes need to implement their own static $instance member.*/
    protected static $instance;

    /**
     * Singletons can only be constructed once, so the __construct method is locked down.  It does call construct() which allows extending classes to implement their own logic.
     */
    protected final function __construct() {
        $this->construct();
    }

    /**
     * Empty method for extending classes to override. Extending classes can put their construction logic here which will be called when the Singleton makes itself.
     */
    abstract protected function construct();

    /**
     * If the Singleton has not yet been created, the construct() method of the extending class will be called and will store the constructed object in the static $instance member.
     * If the Singleton has been created before, will simply return the reference stored in $instance.
     * @return static The singleton instance of the class.
     */
    final public static function get() {
        if (!isset(static::$instance)) {
            $className = get_called_class();
            $new_instance = new $className();
            //extending classes can set $instance to any value, so check to make sure it's still unset before giving it the default value.
            if (!isset(static::$instance)) {
                static::$instance = $new_instance;
            }
        }
        return static::$instance;
    }

    /**
     * Cloning would create a second instance of the Singleton class, so disallow it and trigger and error.
     */
    final public function __clone() {
        trigger_error("Unable to clone singleton class __CLASS__", E_USER_ERROR);
    }

    /**
     * Unserializing can create a second instance of the Singleton class, so disallow it and trigger and error.
     */
    final public function __wakeup() {
        trigger_error("Unable to unserialize singleton class __CLASS__", E_USER_ERROR);
    }
}
