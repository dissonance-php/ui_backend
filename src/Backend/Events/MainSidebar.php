<?php


namespace Symbiotic\UIBackend\Events;

use Psr\EventDispatcher\StoppableEventInterface;
use Psr\SimpleCache\CacheInterface;
use Symbiotic\Apps\AppsRepositoryInterface;
use Symbiotic\Auth\AuthServiceInterface;
use Symbiotic\Auth\UserInterface;

class MainSidebar implements StoppableEventInterface
{
    protected CacheInterface $cache;

    protected ?array $items = null;

    protected bool $stopped = false;

    protected string $cache_key;

    protected AppsRepositoryInterface $apps;

    public function __construct(CacheInterface $cache, AppsRepositoryInterface $appsRepository)
    {
        $this->cache = $cache;
        $this->apps = $appsRepository;
        $this->cache_key = \md5(__CLASS__);
        if ($this->cache && $this->cache->has($this->cache_key)) {
            $items = $this->cache->get($this->cache_key);
            if(is_array($items)) {
                $this->items = $items;
                $this->stopped = true;
            }

        }
    }

    /**
     *
     * @return array ['<a href..></a>','<icon><a href...>']
     */
    public function getItems(): array
    {

        /**
         * @var AuthServiceInterface $auth
         */
        $auth = \_S\core(AuthServiceInterface::class);
        $user = $auth->getIdentity();

        $group = $user ? $user->getAccessGroup() : UserInterface::GROUP_GUEST;

        if (!$this->stopped && $this->cache) {
            $this->cache->set($this->cache_key, $this->items, 3600);
        }
        return $this->items;
    }

    /**
     * Добавление ссылки в меню
     *
     * @param string $title Заголовок
     * Allowed    ('app_id::translate.key' , '<s>BLINK TITLE</s>', 'text title')
     * @param string $href Ссылка ('https://d.com/link','javascript:call_func()')
     * @param string|null $icon_html img tag or svg  ('<img src...>','<svg>...</svg>')
     */
    public function addItem(string $title, string $href, string $icon_html = null)
    {
        $this->items[] = ($icon_html ? $icon_html : '') . '<a href="' . $href . '">' . \_S\lang($title) . '</a>';
    }

    /**
     *
     * @param string $html_link
     */
    public function addHtml(string $html_link)
    {
        $this->items[] = $html_link;
    }

    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }
}