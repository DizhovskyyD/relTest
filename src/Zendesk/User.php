<?php

declare(strict_types=1);

namespace Zendesk;

class User
{
    private $id;
    private $url;
    private $name;
    private $emale;

    /**
     * @param Zendesk $connekt
     * @param $id
     */
    public function __construct(Zendesk $connekt,$id)
    {
        $userinfo = (new UsersInfo($connekt))->getUserInfoById($id);

        $this->id = $id;
        $this->url = $userinfo['user']['url'];
        $this->name = $userinfo['user']['name'];
        $this->emale = $userinfo['user']['email'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl():string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmale():string
    {
        return $this->emale;
    }
}