<?php

namespace App\Traits;

use App\User;
use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use Laravel\Passport\Token;

trait OauthTrait
{
    /**
     * 解析Token
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function parseToken($request)
    {
        $bearerToken = $request->bearerToken();
        $tokenId= (new Parser())->parse($bearerToken)->getHeader('jti');
        return Token::find($tokenId);
    }

    public function verifyPerminssion(Request $request, $perminssion)
    {
        $data = $this->parseToken($request);
        if ($data->client->password_client) {
            $user =  $data->user;
        } else {
            $user = User::find($data->client->user_id)->first();
        }
        return  $user->can($perminssion);
    }
}
