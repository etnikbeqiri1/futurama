<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Ticket.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class TicketRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();
    }

    /**
     * @param array $array
     * @return Ticket
     * @throws Exception
     */
    private function mapTicket(array $array)
    {
        return new Ticket($array["ticket_id"],
            $array["ticket_email"],
            $array["ticket_sex"],
            $array["ticket_country"],
            $array["ticket_name"],
            $array["ticket_message"],
            $array["ticket_date"]
        );
    }

    public function insert(Ticket $ticket)
    {
        $sql = $this->connection->prepare("INSERT INTO ticket(ticket_email, ticket_sex, ticket_country, ticket_name, ticket_message) 
                                            VALUES (:ticket_email, :ticket_sex, :ticket_country, :ticket_name, :ticket_message)");
        $email = $ticket->getEmail();
        $sex = $ticket->getSex();
        $country = $ticket->getCountry();
        $name = $ticket->getName();
        $message = $ticket->getMessage();
        $sql->bindparam(":ticket_email", $email);
        $sql->bindparam(":ticket_sex", $sex);
        $sql->bindparam(":ticket_country", $country);
        $sql->bindparam(":ticket_name", $name);
        $sql->bindparam(":ticket_message", $message);

        $sql->execute();

    }

    public function delete(Ticket $ticket)
    {
        $query = $this->connection->prepare("DELETE FROM ticket WHERE ticket_id = :ticket_id");
        $id = $ticket->getId();
        $query->bindparam(":ticket_id", $id);
        $query->execute();

    }

    public function update(Ticket $ticket)
    {
        $query = $this->connection->prepare("UPDATE FROM tickets SET ticket_email = :ticket_email,
                                            ticket_sex = :ticket_sex,
                                            ticket_country = :ticket_country
                                            ticket_name = :ticket_name
                                            ticket_message = :ticket_message
                                            WHERE ticket_id = :ticket_id");
        $email = $ticket->getEmail();
        $sex = $ticket->getSex();
        $country = $ticket->getCountry();
        $name = $ticket->getName();
        $message = $ticket->getMessage();

        $id = $ticket->getId();


        $query->bindparam(":ticket_email", $email);
        $query->bindparam(":ticket_sex", $sex);
        $query->bindparam(":ticket_country", $country);
        $query->bindparam(":ticket_name", $name);
        $query->bindparam(":ticket_message", $message);
        $query->bindparam(":ticket_id", $id);
        $query->execute();

    }

    /**
     * @return Ticket[]
     * @throws Exception
     */
    public function listAll()
    {
        $tickets = [];
        $sql = $this->connection->prepare("SELECT * FROM ticket");
        $sql->execute();

        $results = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $tickets[] = $this->mapTicket($result);
        }
        return $tickets;
    }

    /**
     * @param $id
     * @return Ticket|null
     * @throws Exception
     */
    public function get($id)
    {
        $sql = $this->connection->prepare("SELECT * FROM ticket WHERE ticket_id = :ticket_id");
        $sql->bindparam(":ticket_id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if ($result == null) {
            return null;
        }

        return $this->mapTicket($result);
    }
}