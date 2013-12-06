<?php

namespace Github\HttpClient\Cache;

use Guzzle\Http\Message\Response;
use Gaufrette\Filesystem;

class GaufretteCache implements CacheInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $content = $this->filesystem->read($id);

        return unserialize($content);
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, Response $response)
    {
        $this->filesystem->write($id, serialize($response));
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedSince($id)
    {
        if ($this->filesystem->has($id)) {
            return $this->filesystem->mtime($id);
        }

        return null;
    }
}