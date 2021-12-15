<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Message.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class MessageRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();
    }

    /**
     * @param Message $message
     */
    public function insert(Message $message)
    {
        $sql = "INSERT INTO `message` (`message_id`, `message_sender`, `message_text`, `message_date`, `message_order`) VALUES (NULL, :sender, :text, current_timestamp(), :order); ";

        $queryEx = $this->connection->prepare($sql);

        $sender = $message->getMessageSender();
        $text = $message->getText();
        $order = $message->getOrder();

        $queryEx->bindparam(":sender", $sender);
        $queryEx->bindparam(":text", $text);
        $queryEx->bindparam(":order", $order);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Message", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Message $message
     */
    public function update(Message $message)
    {
        $sql = "UPDATE `message` SET `message_sender` = :sender,
                `message_text` = :text,
                `message_date` =  :date,
                `message_order` = :order
                WHERE `message`.`message_id` = :id;";

        $queryEx = $this->connection->prepare($sql);
        $timex = time();
        $sender = $message->getMessageSender();
        $text = $message->getText();
        $order = $message->getOrder();
        $id = $message->getMessageId();


        $queryEx->bindparam(":sender", $sender);
        $queryEx->bindparam(":text", $text);
        $queryEx->bindparam(":time", $timex);
        $queryEx->bindparam(":order", $order);
        $queryEx->bindparam(":id", $id);

        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Message", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Message $message
     */
    public function delete(Message $message)
    {
        $sql = "DELETE FROM `message` WHERE `message`.`message_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $message->getMessageId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Message", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return Message|null
     * @throws Exception
     */
    public function get($id)
    {
        $sql = $this->connection->prepare("SELECT * FROM message WHERE message_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if ($result == null) {
            return null;
        }

        return $this->mapMessage($result);
    }


    /**
     * @param array $array
     * @return Message
     */
    private function mapMessage(array $array)
    {
        return new Message($array["message_id"]
            , $array["message_sender"]
            , $array["message_text"]
            , $array["message_date"]
            , $array["message_order"]);
    }

    /**
     * @return Message[]
     * @throws Exception
     */
    public function listAll($limit = null)
    {
        $messages = [];
        if (is_numeric($limit)) {
            $limit = "LIMIT " . $limit;
        } else {
            $limit = "";
        }
        $sth = $this->connection->prepare("SELECT * FROM `message` " . $limit);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $messages[] = $this->mapMessage($array);
        }

        return $messages;
    }

    /**
     * @return Message[]
     * @throws Exception
     */
    public function listMessagesNewerThen($order_id, $timestamp)
    {
        $messages = [];
        $sth = $this->connection->prepare("SELECT * FROM `message` where message_date > :timestamp and message_order = :order_id");
        //log_message("SELECT * FROM `message` where message_date > '" . $timestamp . "' and message_order = " . $order_id);
        $sth->bindparam("timestamp", $timestamp);
        $sth->bindparam("order_id", $order_id);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $messages[] = $this->mapMessage($array);
        }

        return $messages;
    }

}

?>
