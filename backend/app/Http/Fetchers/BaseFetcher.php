<?php namespace App\Http\Fetchers;

use Illuminate\Http\Request;

use App\Models\Handle;
use App\Models\Entity;
use App\Models\Provider;

// use App\Models\Fetch;


abstract class BaseFetcher
{

    protected $fetcherType;

    protected $nextFetcher;


    /*
     * Create a new Fetcher instance.
     *
     */
    public function __construct($fetcherType)
    {
        $this->fetcherType = $fetcherType;
    }
    
    /**
     * Attach the next Fetch to call if not matching.
     * Or chain to the current nextFetcher;
     *
     */
    public function attachNextFetcher(BaseFetcher $nextFetcher)
    {
        if ($this->nextFetcher) {
            $this->nextFetcher = $nextFetcher;
        } else {
            $this->nextFetcher->attachNextFetcher($nextFetcher);
        }
    }

    /**
     *
     *
     */

    public function fetch($handle)
    {
        var_dump($handle->entity->name);
        // ? Is the right Fetcher
        if (strcasecmp($this->fetcherType, $handle->service->name) == 0) {
            $data = $this->handle($handle->entity);
            if($data && !empty($data)) {
                return $this->store($data, $handle);
            }
        }else {
            if ($this->nextFetcher) {
                return $this->nextFetcher->fetch($handle);
            }
        }
        return null;
    }


    /**
     * Store the Handle Fetchin' result
     *
     */
    public function store($data, $handle)
    {
        // Store the data into Fetch DB-Table
        // Fetch::create([
            // 'data' => $data,
            // 'handler_id' => $handle->id;
        // ])
    }


    /**
     * Handle the fetch
     *
     */
    abstract protected function handle(Entity $entity);
}
