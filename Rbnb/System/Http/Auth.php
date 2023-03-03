<?php

namespace Rbnb\System\Http;

use Rbnb\System\Settings;
use Rbnb\System\Session\Session;

use Rbnb\Database\Repository\RepositoryManager;

class Auth
{
	public const ERROR_EMAIL_MISSING = -1;
	public const ERROR_EMAIL_BAD = -2;
	public const ERROR_PASSWORD_MISSING = -3;
	public const ERROR_PASSWORD_BAD = -4;

	private $user = null;

	public static function hashData( string $data ): string
	{
		// Basique: sha512 sur le mot de passe
		// Secure: sha512 sur une chaîne: SEL.mdp
		// Secure+: sha512 sur une chaîne: SEL.mdp.POIVRE
		// Secure++: Secure+ avec SEL et POIVRE unique pour chaque utilisateur
		// Ultra Secure: sha512 sur un sha512 d'un sha512 d'un sha512, etc. des autres méthodes
		// - en option: avec la fonction PHP hash_pbkdf2()

		// Option retenue pour ce projet: Secure+ (SEL et POIVRE dans settings.php)
		$settings = Settings::instance();
		$string = $settings->get( 'salt' ) . $data . $settings->get( 'pepper' );

		return hash( 'sha512', $string );
	}

	public function __construct()
	{
		$this->user = Session::get( Session::USER );
	}

	public function checkLogin( string $email, string $password ): int
	{
		// Méthode 1: renvoie 0 ligne si le couple email/password est inxistant
		// SELECT id FROM users WHERE email = 'email@saisi' AND password = 'hash_du_mdp'
		// +: L'erreur affichée à l'utilisateur est imprécise, cela rend moins facile une intrusion manuelle
		// -: En terme d'expérience utilisateur on préfère détailler les erreurs

		// Méthode 2 (retenue): On teste chaque champ pour afficher les erreurs en détail
		// SELECT * FROM users WHERE email = 'email@saisi'
		// Si aucun résultat: "Email inconnu"
		// Sinon on utilise compare le mot de passe saisi avec celui du résultat

		if( empty( $email ) ) return self::ERROR_EMAIL_MISSING;

		if( empty( $password ) ) return self::ERROR_PASSWORD_MISSING;

		$user_repo = RepositoryManager::manager()->usersRepository();

		$user = $user_repo->getByEmail( $email );

		if( is_null( $user ) ) return self::ERROR_EMAIL_BAD;

		$success = $user->password === self::hashData( $password );

		if( ! $success ) return self::ERROR_PASSWORD_BAD;

		// On supprime le mot de passe de l'objet
		$user->password = null;

		Session::set( SESSION::USER, $user );

		return $user->role_id;
	}
}