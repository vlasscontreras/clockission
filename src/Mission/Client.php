<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Mission;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use VlassContreras\Clockission\Contracts\MissionSlip;

class Client
{
    /**
     * Client object.
     *
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * Cookie jar.
     *
     * @var CookieJarInterface
     */
    private CookieJarInterface $cookieJar;

    /**
     * Base URI.
     *
     * @var string
     */
    private string $baseUri = 'https://app.mission.dev';

    /**
     * CSRF token.
     *
     * @var string
     */
    private string $csrfToken;

    /**
     * Set up the client.
     * @param string $username
     * @param string $password
     */
    public function __construct(private string $username, private string $password)
    {
        $this->setCookieJar();
        $this->setClient();
    }

    /**
     * Authenticate user.
     *
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function authenticate(): ResponseInterface
    {
        $token = $this->findAuthenticityToken();

        $response = $this->client->request('POST', '/users/sign_in', [
            'form_params' => [
                'authenticity_token' => $token,
                'user[email]' => $this->username,
                'user[password]' => $this->password,
            ],
        ]);

        $this->csrfToken = $this->findCsrfToken($response);

        return $response;
    }

    /**
     * Push a time slip.
     *
     * @param MissionSlip $timeSlip
     * @param int $timeCardId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function pushTimeSlip(MissionSlip $timeSlip, int $timeCardId): ResponseInterface
    {
        return $this->client->request('POST', '/platform/time_slips', [
            'headers' => [
                'accept-language'  => 'en-US',
                'accept'           => 'application/javascript, */*; q=0.01',
                'content-type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
                'origin'           => $this->baseUri,
                'referer'          => $this->baseUri . '/platform/time_cards',
                'user-agent'       => $this->getUserAgent(),
                'x-csrf-token'     => $this->csrfToken,
                'x-requested-with' => 'XMLHttpRequest',
            ],
            'query' => [
                'time_card_id' => $timeCardId,
            ],
            'form_params' => [
                'time_slip[activity_type]' => $timeSlip->getActivityType(),
                'time_slip[team_id]'       => $timeSlip->getTeamId(),
                'time_slip[activity_date]' => $timeSlip->getDate(),
                'time_slip[description]'   => $timeSlip->getDescription(),
                'time_slip[time_logged]'   => $timeSlip->getTimeLogged(),
            ],
        ]);
    }

    /**
     * Create the cookie jar
     *
     * @return void
     */
    protected function setCookieJar()
    {
        $this->cookieJar = new CookieJar();
    }

    /**
     * Set the client.
     *
     * @return void
     */
    protected function setClient()
    {
        $this->client = new HttpClient([
            'base_uri' => $this->baseUri,
            'cookies'  => $this->cookieJar,
        ]);
    }

    /**
     * Get the user agent.
     *
     * @return string
     */
    protected function getUserAgent(): string
    {
        return 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) '
            . 'AppleWebKit/537.36 (KHTML, like Gecko) '
            . 'Chrome/97.0.4692.71 Safari/537.36';
    }

    /**
     * Find the authenticity token.
     *
     * @return string
     * @throws GuzzleException
     * @throws RuntimeException
     */
    protected function findAuthenticityToken()
    {
        $response = $this->client->request('GET', '/users/sign_in');

        preg_match(
            '/name="authenticity_token" value="(.[^"]*)" \/>/m',
            $response->getBody()->getContents(),
            $matches
        );

        if (!isset($matches[1])) {
            throw new \RuntimeException('Could not find authenticity token');
        }

        return $matches[1];
    }

    /**
     * Find the CSRF token.
     *
     * @param ResponseInterface $response
     * @return string
     * @throws RuntimeException
     */
    protected function findCsrfToken(ResponseInterface $response)
    {
        preg_match(
            '/name="csrf-token" content="(.[^"]*)" \/>/m',
            $response->getBody()->getContents(),
            $matches
        );

        if (!isset($matches[1])) {
            throw new \RuntimeException('Could not find the CSRF token');
        }

        return $matches[1];
    }
}
