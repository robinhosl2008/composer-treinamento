<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Summary of Buscador
 */
class Buscador
{
    /** @var ClientInterface */
    private $httpClient;
    /** @var Crawler */
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    /**
     * Summary of buscar
     * @param string $url
     * @return array
     */
    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request(
            'GET',
            $url
        );

        $html = $resposta->getBody();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $curso) {
            $cursos[] = $curso->textContent;
        }

        return $cursos;
    }
}
