<?php namespace App\Http\Fetchers;

use Illuminate\Http\Request;

use App\Models\Handle;
use App\Models\Entity;
use App\Models\Provider;

use App\Models\Fetch;


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
        // ? Is the right Fetcher
        if (strcasecmp($this->fetcherType, $handle->service->name) == 0) {
            $data = $this->handle($handle->entity);
            if ($data && !empty($data)) {
                return $this->store($data, $handle);
            }
        } else {
            if ($this->nextFetcher) {
                return $this->nextFetcher->fetch($handle);
            }
        }
        return true;
    }


    /**
     * Store the Handle Fetchin' result
     *
     */
    public function store($datas, $handle)
    {
        foreach ($datas as $data) {
            $fetcher = Fetch::where('medium_id', $data['id'])
                                ->where('handle_id',$handle->id)
                                ->first();

            if(is_null($fetcher) || empty($fetcher)){
                Fetch::create([
                    'medium_id' => $data['id'],
                    'data' => json_encode($data),
                    'handle_id' => $handle->id
                ]);
            }           
        }

        return true;
    }


    /**
     * Handle the fetch
     *
     */
    abstract protected function handle(Entity $entity);
}
