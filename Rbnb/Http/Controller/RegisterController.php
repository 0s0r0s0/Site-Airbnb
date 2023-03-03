<?php

namespace Rbnb\Http\Controller;

use Rbnb\Rbnb;
use Rbnb\Database\Model\Users;
use Rbnb\Database\Repository\RepositoryManager;
use Rbnb\System\Http\Controller;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;


class RegisterController extends Controller
{
    public function index(): void
    {
        echo $this->twig->render('visitor/register.twig', ['title' => 'Inscription']);
    }

    public function insert( ServerRequest $request )
    {
        $router = Rbnb::app()->getRouter();
        $data = $request->getParsedBody();

        $input['role_id'] = $data[ 'role_id' ] ?? -1;
        $input['email'] = $data[ 'email' ] ?? -1;
        $input['password'] = $data[ 'password' ] ?? -1;
        $input['username'] = $data[ 'username' ] ?? -1;

        if( ! empty( $input ) && ! array_search( null, $input )) {
            $repo = RepositoryManager::manager()->UsersRepository();
            $success = $repo->insert( new Users( $input ) );

            if( ! $success ) {
                // TODO: Gérer une erreur d'insertion
            }else{
                return new RedirectResponse( $router->url( 'login' )  );
            }
        }
        else {
            // TODO: Gérer une erreur de formulaire
        }

        return new RedirectResponse( $router->url('register') );
    }
}