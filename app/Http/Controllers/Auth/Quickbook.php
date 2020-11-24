<?php

namespace App\Http\Controllers\Auth;

use Session, QuickbooksService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Quickbook extends Controller {
    public function __construct(){
        if(Session::get('accessTokenJSON') == null)
            return redirect('oauth/quickbooks');
    }

    public function set_config(){
        if(Session::get('accessTokenJSON') == null){
            $dataService = QuickbooksService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
                'ClientSecret' =>  env('QUICKBOOKS_CLIENT_SECRET'),
                'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
                'scope' => 'com.intuit.quickbooks.accounting openid profile email phone address',
                'baseUrl' => "development"
            ));
        }else{
            $dataService = QuickbooksService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
                'ClientSecret' =>  env('QUICKBOOKS_CLIENT_SECRET'),
                'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
                'scope' => 'com.intuit.quickbooks.accounting openid profile email phone address',
                'baseUrl' => "development",
                'accessTokenKey' => Session::get('accessTokenJSON')['access_token'],
                'refreshTokenKey' => Session::get('accessTokenJSON')['refresh_token'],
                'QBORealmID' => Session::get('accessTokenJSON')['realmID']
            ));

            $dataService->updateOAuth2Token(Session::get('accessToken'));
        }

        return $dataService;
    }

    public function get_auth(){
        $dataService = $this->set_config();
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $auth_url = $OAuth2LoginHelper->getAuthorizationCodeURL();
        $data = ['auth_url' => $auth_url];

        return view('index', $data);
    }

    public function callback(Request $request){
        $params = $request->all();
        $dataService = $this->set_config();
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        // Update the OAuth2Token
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($params['code'], $params['realmId']);
        $dataService->updateOAuth2Token($accessToken);

        $accessTokenJSON = array(
            'token_type' => 'bearer',
            'access_token' => $accessToken->getAccessToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'realmID' => $accessToken->getRealmID(),
            'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
            'expires_in' => $accessToken->getAccessTokenExpiresAt()
        );

        Session::put('accessToken', $accessToken);
        Session::put('accessTokenJSON', $accessTokenJSON);

        return redirect('quickbooks');
    }

    public function quickbooks_access(){
        if(Session::get('accessTokenJSON') == null)
            return redirect('oauth/quickbooks');
        else
            return view('panel/quickbooks', []);
    }

}
