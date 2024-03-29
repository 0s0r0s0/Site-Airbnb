<?php


namespace Rbnb\System;


use Rbnb\Model\Repository\RepositoryManager;
use Rbnb\System\Session;
use Rbnb\System\Settings;

class Auth
{
    public const ERROR_EMAIL_MISSING = -1;
    public const ERROR_EMAIL_BAD = -2;
    public const ERROR_PASSWORD_MISSING = -3;
    public const ERROR_PASSWORD_BAD = -4;

    private $user = null;

    public static function hashData(string $data): string
    {
        $settings = Settings::instance();
        $string = $settings->get('salt') . $data . $settings->get('pepper');

        return hash('sha512', $string);
    }

    public function __construct()
    {
        $this->user = Session::get(Session::USER);
    }

    public function checkLogin(string $email, string $password): int
    {

        if (empty($email)) return self::ERROR_EMAIL_MISSING;

        if (empty($password)) return self::ERROR_PASSWORD_MISSING;

        $user_repo = RepositoryManager::manager()->userRepository();

        $user = $user_repo->getByEmail($email);

        if (is_null($user)) return self::ERROR_EMAIL_BAD;

        $success = $user->password === self::hashData($password);

        if (!$success) return self::ERROR_PASSWORD_BAD;

        // On supprime le mot de passe de l'objet
        $user->password = null;

        Session::set(SESSION::USER, $user);

        return $user->role_id;
    }
}
