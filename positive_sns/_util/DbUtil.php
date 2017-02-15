<?php

/**
 * Created by PhpStorm.
 * User: keita shimoasto
 * Date: 2017/02/01
 * Time: 19:43
 */
class DbUtil
{
    private $dbHost = 'localhost';
    private $dbName = 'a-team-2ch';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8';
    private $dbh;
    private $pdo;

    /**
     * DbUtil constructor.
     */
    public function __construct()
    {
        $this->dbh = "mysql:dbname=$this->dbName;host=$this->dbHost;charset=$this->charset";
        $this->init();
    }


    /**
     * DBへ接続する$pdoのオブジェクトを作成
     */
    private function init()
    {
        try {
            $this->pdo = new PDO(
                $this->dbh,
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
     /**
     * 認証機能
     */
    public function searchLogin($id,$pass) {
        $loginData = [];
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE rogin_id = :id and rogin_pass = :pass");
            $stmt->bindValue(':id',$id);
            $stmt->bindValue(':pass',$pass);
            $stmt->execute();
            $loginData = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $loginData;
    }

    /**
     * table名を受け取り、そのデータすべて取得
     *
     * @param $tableName
     * @return array|bool
     */
    public function selectAll($tableName)
    {
        $sql = "SELECT * FROM $tableName";
        return $this->executeQuery($sql);
    }

    /**
     * ページネーションを実行する
     * @param $tableName
     * @param int $offset
     * @param int $count
     * @return bool
     */
    public function paginate($tableName, $offset, $count) {
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName limit :offset, :count");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        return $this->executeStatement($stmt);
    }

    /**
     * @param $tableName
     * @return bool
     */
    public function selectAllCount($tableName) {
        $sql = "SELECT COUNT(*) as count FROM $tableName";
        return $this->executeFirst($sql);
    }

    /**
     * sqlを実行するメソッド
     * @param $sql
     * @return bool
     */
    public function executeFirst($sql) {
        try {
            $query = $this->pdo->query($sql);
            $data = $query->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $data;
    }

    /**
     * sqlを実行するメソッド
     * @param $sql
     * @return bool
     */
    public function executeQuery($sql) {
        try {
            $query = $this->pdo->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $data;
    }

    /**
     * @param $stmt
     * @return bool
     */
    public function executeStatement($stmt) {
        try {
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $data;
    }

    /**
     * スレッドテーブルを検索する
     * @param $threadId
     * @return array
     */
    public function selectByThreadId($threadId)
    {
        $data = [];
        // 空チェックをしている。threadsIdがわたらない場合のチェック
        if ($threadId === '') {
            echo 'threadIDを渡してください';
            return $data;
        }

        // DB関連はエラーが多いと思うので、try { } catch () {}で、エラーをキャッチできるようにする
        // try {} の中には、エラーが発生すると思われる処理を書く
        // catch() {} は、エラーが発生したときにこの中になる。エラーが発生した場合にリプレイスなどの処理を書く
        // 要はエラーが発生したときに白い画面を見せないようにするために配慮です。
        try {
            // SQLをまずは書く。この時直接SQL文に変数を渡さないでプレースホルダーという手法を取る
            // これを使わないとエスケープしてくれない。いわゆるSQLインジェクションを許してしまう
            $stmt = $this->pdo->prepare('SELECT * FROM threads WHERE id = :threadId');

            // ここで、変数と先ほどの":threadId"をバインド（紐付け）している
            // 第一引数がプレースホルダーで用意した名前（':threadId'）
            // 第二引数が渡したい値・変数名（$threadId）
            // 第三引数は無くても良いが、型を決めて渡したい場合は使う。今回は数値なのでInt型として渡すことを定義している
            $stmt->bindValue(':threadId', $threadId, PDO::PARAM_INT);

            // ここで渡したSQL文を実行している
            $stmt->execute();

            // 実行した後、値を取り出すのがfetch()とfetchAll()。全部取得したい場合はfetchAll()を使う
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $data;
    }

    /**
     * コメントテーブルを検索する
     * @param $commentId
     * @return array
     */
    public function selectByCommentId($commentId)
    {
        $data = [];
        if ($commentId === '') {
            echo 'commentIDを渡してください'; // fix me
            return $data;
        }
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE id = :commentId');
            $stmt->bindValue(':commentId', $commentId, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $data;
    }
    
    /**
     * userテーブルを検索する
     * @param $commentId
     * @return array
     */
    public function selectByUserData($dearName) {
        $selectByUserData = [];
        
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :dearName');
            $stmt->bindValue(':dearName', $dearName, PDO::PARAM_INT);
            $stmt->execute();
            $selectByUserData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $selectByUserData;
    }

    /**
     * スレッドを削除するメソッド
     * @param $threadId
     * @param $deleteKey
     */
    public function deleteByThreadId($threadId, $deleteKey)
    {
        $threadRecord = $this->selectByThreadId($threadId);
        // もらったthreadIdでDBにデータが無かった場合
        if (empty($threadRecord)) {
            return false;
        }

        $execDeleteKey = $threadRecord['delete_key'];
        if ($deleteKey === $execDeleteKey) {
            // delete keyがマッチすれば削除
            try {
                $stmt = $this->pdo->prepare('DELETE FROM threads WHERE id = :threadId');
                $stmt->bindValue(':threadId', $threadId, PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return true;
        } else {
            // マッチしない場合
            return false;
        }
    }
    
   public function insertComment($threadsId,$comment,$fromName,$dearName,$fromId,$toId,$deleteKey,$created,$fromPoint,$toPoint,$createDate){
        try{
            $this->pdo->beginTransaction();
            $sql ="INSERT INTO comments(threads_id,comment,from_name,dear_name,from_id,to_id,delete_key,created,from_point,to_point,create_date)VALUES(:thredsIdData,:commentData,:fromNameData,:dearNameData,:fromIdData,:toIdData,:deleteKey,:created,:fromPoint,:toPoint,:createDate)";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':thredsIdData',$threadsId);
            $stmh->bindValue(':commentData',$comment);
            $stmh->bindValue(':fromNameData',$fromName);
            $stmh->bindValue(':dearNameData',$dearName);
            $stmh->bindValue(':fromIdData',$fromId); 
            $stmh->bindValue(':toIdData',$toId); 
            $stmh->bindValue(':deleteKey',$deleteKey); 
            $stmh->bindValue(':created',$created);
            $stmh->bindValue(':fromPoint',$fromPoint);
            $stmh->bindValue(':toPoint',$toPoint);
            $stmh->bindValue(':createDate',$createDate); 
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
    }
    
    
    public function deleteComment($threadsId,$commentsId,$deleteKey){

            
            try{       
                    $delete ="DELETE FROM comments WHERE id = :commentsId AND delete_key = :deleteKey";
                    $stmh = $this->pdo->prepare($delete);
                    $stmh->bindValue(':commentsId',$commentsId);
                    $stmh->bindValue(':deleteKey',$deleteKey);             
                    $stmh->execute();
                 
            }catch(PDOException $e){
//                $this->pdo->rollBack();
                echo('Error:'.$e->getMessage());
                return false;
            }
            return true;
        }  
        
        
        public function insertUser($userName,$roginID,$roginPass){
        try{
            $this->pdo->beginTransaction();
            $sql ="INSERT INTO user(name,rogin_id,rogin_pass)VALUES(:NAME,:roginId,:roginPass)";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':NAME',$userName);
            $stmh->bindValue(':roginId',$roginID); 
            $stmh->bindValue(':roginPass',$roginPass); 
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
    }
    
    public function deleteUser($threadsId,$commentsId,$deleteKey){

            
            try{

                    $delete ="DELETE FROM comments WHERE id = :commentsId AND delete_key = :deleteKey";
                    $stmh = $this->pdo->prepare($delete);
                    $stmh->bindValue(':commentsId',$commentsId);
                    $stmh->bindValue(':deleteKey',$deleteKey);             
                    $stmh->execute();    
                        
            }catch(PDOException $e){
                echo('Error:'.$e->getMessage());
                return false;
            }
            return true;
        }
        
        
        /**
     * ユーザーのデータすべて取得
     */
    public function getUserData($user) {
        $userData = [];
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM $user");
            $stmt->execute();
            $userData = $stmt->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $userData;
    }
        
    public function getThredsData($threadsId) {
        $threadsData = [];
        try{
            $threadsData = $this->pdo->prepare("select threads.id as threads_id, threads.threads_name, threads.delete_key, threads.created, comments.id as comments_id, comments.comment,  comments.unique_id, comments.from_name, comments.dear_name, comments.delete_key, comments.created from threads left join comments on (threads.id = comments.threads_id) where threads.id = :threadsId");
            $threadsData->bindValue(':threadsId',$threadsId);      
            $threadsData->execute();
            $threadsData = $threadsData->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $threadsData;
        
    }
    
    public function getCommentData($userId) {
        $userCommentdata = [];
        try{
            $userCommentdata = $this->pdo->prepare('SELECT * FROM comments WHERE to_id = :userId');
            $userCommentdata->bindValue(':userId',$userId);      
            $userCommentdata->execute();
            $userCommentdata = $userCommentdata->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $userCommentdata;
        
    }
    
     /*
     * ユーザーー編集のメソッド
     */
    public function editUser($userId,$userName){
        try{
            $this->pdo->beginTransaction();
            $sql ="UPDATE user SET name = :Name WHERE id = :userId";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':userId',$userId);
            $stmh->bindValue(':Name',$userName);            
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
    }
    
    
     
}
