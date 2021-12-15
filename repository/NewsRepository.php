<?php
require_once(__DIR__.'/../core/Database.php');
require_once(__DIR__.'/../model/News.php');
require_once(__DIR__ . "/../repository/AuditRepository.php");

class NewsRepository{

    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();
    }

    public function insert(News $news): void{
        $sql = $this->connection->prepare("INSERT INTO news (news_title, news_content, news_image) VALUES (:news_title, :news_content, :news_image)");
        $title = $news->getTitle();
        $content = $news->getContent();
        $image = $news->getImage();
        $sql->bindparam(":news_title", $title);
        $sql->bindparam(":news_content", $content);
        $sql->bindparam(":news_image", $image);
        $sql->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "News", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    public function update(News $news): void{
        $sql = $this->connection->prepare("UPDATE news SET news_title=:news_title,
                                           news_content:news_content,
                                           news_image:news_image
                                           WHERE news_id=:news_id");
        $id = $news->getId();
        $title = $news->getTitle();
        $content = $news->getContent();
        $image = $news->getImage();

        $sql->bindparam("news_title", $title);
        $sql->bindparam("news_content", $content);
        $sql->bindparam("news_image", $image);
        $sql->bindparam("news_id", $id);
        $sql->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "News", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    public function delete(News $news): void{
        $sql = $this->connection->prepare("DELETE FROM news WHERE news_id=:news_id");
        $id = $news->getId();
        $sql->bindparam("news_id", $id);
        $sql->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "News", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM news WHERE news_id=:news_id");
        $sql->bindparam("news_id", $id);
        $sql->execute();
        $result = $sql->fetch();
        if($result == null) {
            return null;
        }
        return $this->mapNews($result);
    }

    public function getPagination($start, $end){
        $news = [];
        $sql = $this->connection->prepare("SELECT * FROM news ORDER BY news_date DESC LIMIT :start, :end");
        $sql->bindValue(":start", (int) $start, PDO::PARAM_INT);
        $sql->bindValue(":end", (int) $end, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach($result as $rst){
            $news[] = $this->mapNews($rst);
        }
        return $news;
    }

    public function count(){
        $sql = $this->connection->prepare("SELECT count(*) FROM news");
        $sql->execute();
        return $sql->fetchColumn();
    }

    public function listAll(){
        $news = [];
        $sql = $this->connection->prepare("SELECT * FROM news ORDER BY news_date DESC");
        $sql->execute();

        $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

        foreach($result as $res){
            $news[] = $this->mapNews($res);
        }
        return $news;
    }

    public function mapNews(Array $arr): News{
        return new News($arr['news_id'], $arr['news_title'], $arr['news_content'], $arr['news_image'], $arr['news_date']);
    }
}