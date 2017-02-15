<?php

class SessionUtil {

    public function __construct() {
        session_start();
    }

    /**
     * ユーザーデータを取得
     */
    public function getSessionData($index01) {
        if (isset($_SESSION[$index01]) && !empty($_SESSION[$index01])) {
            $sessionName = $_SESSION[$index01];
            return $sessionName;
        }
        return false;
    }

}
