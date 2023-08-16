<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AuthLoginRequest;
use App\Http\Requests\v1\AuthRegisterRequest;
use App\Services\AuthServices\AuthLoginServiceInterface;
use App\Services\AuthServices\AuthLogoutServiceInterface;
use App\Services\AuthServices\AuthRegisterServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api\v1\Auth
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email, password and token to get the authentication token",
 *     name="Token based auth",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
class AuthController extends Controller
{
    public function __construct(protected AuthRegisterServiceInterface $auth_register_service, protected AuthLoginServiceInterface $auth_login_service, protected AuthLogoutServiceInterface $auth_logout_service)
    {}

    /**
     * @OA\Post(
     *      path="/api/v1/auth/register",
     *      operationId="v1-auth-register",
     *      tags={"authentication"},
     *      summary="Register",
     *      description="Register user",
     *      @OA\Parameter(
     *          name="name",
     *          description="name",
     *          required=true,
     *          in="query",
     *          example="Eduard",
     *          @OA\Schema(
     *              type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="query",
     *          example="eduard.test@gmail.com",
     *          @OA\Schema(
     *              type="string",
     *              format="email"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="password",
     *          description="password",
     *          required=true,
     *          in="query",
     *          example="abcdef",
     *          @OA\Schema(
     *              type="string",
     *              format="password"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          description="password confirmation",
     *          required=true,
     *          in="query",
     *          example="abcdef",
     *          @OA\Schema(
     *              type="string",
     *              format="password"
     *          )
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns void
     */
    public function register(AuthRegisterRequest $request) : JsonResponse
    {
        //do register
        $this->auth_register_service->register(name: $request->name, email: $request->email, password: $request->password);

        return response()->json([])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth/login",
     *      operationId="v1-auth-login",
     *      tags={"authentication"},
     *      summary="Login",
     *      description="Login user",
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="query",
     *          example="eduard.test@gmail.com",
     *          @OA\Schema(
     *              type="string",
     *              format="email"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="password",
     *          description="password",
     *          required=true,
     *          in="query",
     *          example="abcdef",
     *          @OA\Schema(
     *              type="string",
     *              format="password"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="device_name",
     *          description="device name",
     *          required=true,
     *          in="query",
     *          example="web",
     *          @OA\Schema(
     *              type="string"
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns token
     */
    public function login(AuthLoginRequest $request) : JsonResponse
    {
        //do login
        return response()->json(['data' => [
            'token' => $this->auth_login_service->loginApi(email: $request->email, password: $request->password, device_name: $request->device_name)
        ]])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/auth/logout",
     *      operationId="v1-auth-logout",
     *      tags={"authentication"},
     *      summary="Logout",
     *      description="Logout user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns void
     */
    public function logout() : JsonResponse
    {
        //do logout
        $this->auth_logout_service->logoutApi();

        return response()->json()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/auth/user",
     *      operationId="v1-auth-get-user",
     *      tags={"authentication"},
     *      summary="User",
     *      description="get user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns App/Model/User
     */
    public function getUser(Request $request) : JsonResponse
    {
        return response()->json(['data' => [
            'user' => array_intersect_key($request->user()->toArray(), array_flip(['name', 'email']))
        ]])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/auth/refresh-token",
     *      operationId="v1-auth-refresh-token",
     *      tags={"authentication"},
     *      summary="Refresh token",
     *      description="refresh token",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns App/Model/User
     */
    public function refreshToken(Request $request) : JsonResponse
    {
        //do token refresh
        return response()->json(['data' => [
            'token' => $this->auth_login_service->refreshToken()
        ]])->setStatusCode(Response::HTTP_OK);
    }
}
