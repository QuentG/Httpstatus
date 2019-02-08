<?php
namespace controllers\internals;

use \models\Short as ModelShort;

class Short extends \InternalController
{
    public function __construct (\PDO $pdo)
    {
        $this->model_short = new ModelShort($pdo);
    }

    public function minify (string $url)
    {   
        $short = $this->model_short->get_one_by_url($url);

        if ($short)
        {
            return $short['uid'];
        }

        $uid = str_replace('=', '', strtr(base64_encode(random_bytes(4)), '+/', '-_'));

        $this->model_short->create($url, $uid, new \DateTime());
        return $uid;
    }

    public function develop ($uid) : ?string
    {   
        $short = $this->model_short->get_one_by_uid($uid);

        if (!$short)
        {
            return null;
        }

        $short['last_click'] = new \DateTime();

        $this->model_short->modify(
            $short['id'], 
            $short['url'], 
            $short['uid'], 
            $short['last_click']
        );

        return $short['url'];
    }


    public function delete_olds_shorts ()
    {
        $date_limit = new \DateTime();
        $date_limit = $date_limit->sub(new \DateInterval('P1D'));

        $shorts = $this->model_short->get_by_last_click_before($date_limit);

        foreach ($shorts as $short)
        {
            echo "Remove " . $short['uid'] . "...";
            
            $result = $this->model_short->remove($short['id']);

            if ($result)
            {
                echo "ok";
            }
            else
            {
                echo "ko";
            }

            echo "\n";
        }
    }
}
