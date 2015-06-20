<?php

class Messenger {

    /**
     * @var Zend_Session_Namespace
     */
    protected $_unread_messages;

    /**
     * @var Zend_Session_Namespace
     */
    protected $_read_messages;

    /**
     * @var Messenger singleton instance object
     */
    protected static $_instance;

    /**
     * @var int $_MESSAGE_EXPIRY_SECONDS time until a message expires
     */
    protected static $_MESSAGE_EXPIRY_SECONDS = 60;

    /**
     * @var int $_MESSAGE_EXPIRY_HOPS 'hops' until a message expires
     *
     * A hop represents any time the namespace is accessed
     */
    protected static $_MESSAGE_EXPIRY_HOPS = 15;

    /**
     * @var string name of the namespace to store unread messages in
     */
    public static $UNREAD_MESSAGE_NAMESPACE = 'unread_messages';

    /**
     * @var string name of the namespace to store read messages in
     */
    public static $READ_MESSAGE_NAMESPACE = 'read_messages';

    /**
     * Private constructor so class is uninstantiable
     */
    private function __construct() {
        if (!$this->_isSessionStarted()) {
            session_start();
        }
        $this->_unread_messages = new Zend_Session_Namespace(self::$UNREAD_MESSAGE_NAMESPACE);
        $this->_read_messages = new Zend_Session_Namespace(self::$READ_MESSAGE_NAMESPACE);
        session_write_close();
    }

    /**
     * See http://www.php.net/manual/en/function.session-status.php#113468
     *
     * @return bool
     */
    protected function _isSessionStarted()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }


    /**
     * Get the singleton instance of this class
     *
     * @return Messenger the Messenger instance
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new Messenger();
        }
        return self::$_instance;
    }

    /**
     * Call this function from a controller displaying to a view
     *
     * Adds a message to the response to be displayed immediately
     *
     * @param string $message
     */
    public function addMessage($message) {
        if (!$this->_isSessionStarted()) {
            session_start();
        }
        $k = $this->currDateString();
        $this->_unread_messages->$k = $message;
        session_write_close();
    }

    /**
     * @return string the local date as a string
     */
    protected function currDateString() {
        $now = DateTime::createFromFormat('U.u', microtime(true));  // Use microsecond accuracy to act as unique keys
        $now->setTimezone(new DateTimeZone('UTC'));
        $datestr = $now->format('m/d/y h:i:s.u a T');  // Readable by javascript so we can convert to locale string
        return $datestr;
    }

    /**
     * Fetch all read and unread messages in a single array
     *
     * @return array all read and unread messages
     */
    public function getMessages() {
        return array_merge_recursive(Zend_Session::namespaceGet(self::$READ_MESSAGE_NAMESPACE),
                                     Zend_Session::namespaceGet(self::$UNREAD_MESSAGE_NAMESPACE));
    }

    /**
     * Check if there are any unread messages belonging to the current session
     *
     * @return bool true if there are any unread messages
     */
    public function hasUnreadMessages() {
        $ns = Zend_Session::namespaceGet(self::$UNREAD_MESSAGE_NAMESPACE);
        return !empty($ns);
    }

    /**
     * Fetch all unread messages
     *
     * @return array all unread messages
     */
    public function getUnreadMessages() {
        return Zend_Session::namespaceGet(self::$UNREAD_MESSAGE_NAMESPACE);
    }

    /**
     * Called when the user reads the unread messages so that
     * we can move them to the read message namespace
     */
    public function ackUnreadMessages() {
        if (!$this->_isSessionStarted()) {
            session_start();
        }

        $ns = Zend_Session::namespaceGet(self::$UNREAD_MESSAGE_NAMESPACE);
        foreach (array_reverse($ns) as $k => $v) {
            // We want to be able to expire each message individually (if we store the messages
            // as an array, we can only call expire on the whole array, which will override itself)
            // so we make the namespace itself into our messages array.
            $this->_read_messages->$k = array_pop($ns);
            $this->_read_messages->setExpirationSeconds(self::$_MESSAGE_EXPIRY_SECONDS, $k);
            $this->_read_messages->setExpirationHops(self::$_MESSAGE_EXPIRY_HOPS, $k, true);
        }
        $this->_unread_messages->unsetAll();  // We've acknowledged all the unread messages, so remove them
        session_write_close();
    }

}