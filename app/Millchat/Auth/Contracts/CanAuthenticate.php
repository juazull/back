<?php
namespace Millchat\Auth\Contracts;

/**
 * Interface Auth
 *
 * Define el comportamiento que todas las clases de autenticación debe tener.
 */
interface CanAuthenticate
{

    /**
     * Intenta autenticar al usuario, e informa del resultado.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login($email, $password);

    /**
     * Cierra la sesión del usuario.
     */
    public function logout();

    /**
     * Retorna si el usuario está autenticado o no.
     *
     * @return bool
     */
    public function estaAutenticado();

    /**
     * Retorna el usuario autenticado.
     * Si no está autenticado, retorna null.
     *
     * @return null
     */
    public function getUsuarios();
}
