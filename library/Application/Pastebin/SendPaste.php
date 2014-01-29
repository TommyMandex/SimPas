<?php
namespace Application\Pastebin;

use Application\Application;
use Application\Configuration\Configuration;

class SendPaste
{
    use Configuration;

    /**
    * DataBase
    * 
    * @var object
    */
    private $data_source;

    /**
    * Construct
    *
    * @param Application $application
    * @return void
    */
    public function __construct(Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
    }

    /**
    * Send paste
    * 
    * @param array $container
    * @return void
    */
    public function send(array $container) {
        // Prepare query
        $query = $this->data_source
        ->get()
        ->prepare('INSERT INTO ' . $this->config('Database')->prefix . 'pastes (
            unique_id,
            time,
            size,
            length,
            syntax,
            content,
            ip_address,
            raw_content,
            title,
            author,
            start_from_line
        ) VALUES (
            :unique_id,
            :time,
            :size,
            :length,
            :syntax,
            :content,
            :ip_address,
            :raw_content,
            :title,
            :author,
            :start_from_line
        );');

        // Filter
        $query->bindValue(':unique_id', $container['paste_id'], constant('PDO::PARAM_INT'));
        $query->bindValue(':time', $container['paste_time'], constant('PDO::PARAM_INT'));
        $query->bindValue(':size', $container['paste_size'], constant('PDO::PARAM_INT'));
        $query->bindValue(':length', $container['paste_length'], constant('PDO::PARAM_INT'));
        $query->bindValue(':syntax', $container['paste_syntax']);
        $query->bindValue(':content', $container['paste_content']);
        $query->bindValue(':ip_address', $container['paste_client_ip']);
        $query->bindValue(':raw_content', $container['paste_raw_content']);
        $query->bindValue(':title', $container['paste_title']);
        $query->bindValue(':author', $container['paste_author']);
        $query->bindValue(':start_from_line', $container['paste_start_from_line'], constant('PDO::PARAM_INT'));

        // Execute
        $query->execute();
    }

    /**
    * Generate ID
    * 
    * @return int
    */
    public function generateId()
    {
        $id = time();
        $id = substr($id, 2);
        $id = mt_rand(0, 15) . $id;

        $uniq = (int)uniqid();
        $uniq = (isset($uniq[0]) && isset($uniq[1]) ? $uniq[0] . $uniq[1] : 0);

        return (int)$id . $uniq;
    }
}