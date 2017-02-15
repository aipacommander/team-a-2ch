<?php

/**
 * Created by Netbeans.
 * User: KetiaShimosato
 * Date: 2016/07/24
 * Time: 19:43
 */
class DbUtil
{
    private $dbHost = 'localhost';
    private $dbName = 'cms';
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
     * table名を受け取り、そのデータすべて取得
     */
    public function selectAll($tableName)
    {

    }
    
    /**
     * 認証機能
     */
    public function searchLogin($id,$pass) {
        $loginData = [];
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE rogin_id = :id and rogin_pass = :pass");
            $stmh->bindValue(':id',$id);
            $stmh->bindValue(':pass',$pass);
            $stmt->execute();
            $loginData = $stmt->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $loginData;
    }
    
     /**
     * カテゴリーのデータすべて取得
     */
    public function getcategoryData($category) {
        $categoryData = [];
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM $category");
            $stmt->execute();
            $categoryData = $stmt->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $categoryData;
    }
    
    
//    public function getcategoryData2($category) {
//        try{
//            $stmt = $this->pdo->query("SELECT * FROM $category");
//            $categoryData = $stmt->fetchAll();
//        }catch(PDOException $e){
//            echo('Error:'.$e->getMessage());
//            return false;
//        }
//        return $categoryData;
//    }
    
    
    /*
     *  記事一覧取得のメソッド
     */
    public function getAllPostData($post){
        $allPostData = [];
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM $post");
            $stmt->execute();
            $allPostData = $stmt->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $allPostData;
    }
    
    
    /*
     * カテゴリー追加のメソッド
     */
    public function insertCategry($categoryName){
        try{
            $this->pdo->beginTransaction();
            $sql ="INSERT INTO category(category_name)VALUES(:categoryName)";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':categoryName',$categoryName);
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
    }
    
    /*
     * コンテンツ追加のメソッド
     */
    public function insertPost($categoryName,$postTitle,$postContent){
        try{
            $this->pdo->beginTransaction();
            $sql ="INSERT INTO post(category,title,content)VALUES(:categoryName,:postTitle,:postContent)";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':categoryName',$categoryName);
            $stmh->bindValue(':postTitle',$postTitle);
            $stmh->bindValue(':postContent',$postContent);
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
    }
    
    /*
     * カテゴリー編集のメソッド
     */
    public function editCategory($categoryId,$categoryName){
        try{
            $this->pdo->beginTransaction();
            $sql ="UPDATE category SET category_name = :categoryName WHERE id = :categoryId";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':categoryName',$categoryName);
            $stmh->bindValue(':categoryId',$categoryId);
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
    }
    
    /*
     * カテゴリー削除のメソッド
     */
    public function deleteCategory($categoryId){
        try{
            $this->pdo->beginTransaction();
            $sql ="UPDATE category SET category_name = :categoryName WHERE id = :categoryId";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':categoryName',$categoryName);
            $stmh->bindValue(':categoryId',$categoryId);
            $stmh->execute();
            $this->pdo->commit();
        }catch(PDOException $e){
            $this->pdo->rollBack();
            echo('Error:'.$e->getMessage());
            return false;
        }
        return true;
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
    
    public function insertComment($threadsId,$fromName,$dearName,$comment,$deleteKey,$created){
        try{
            $this->pdo->beginTransaction();
            $sql ="INSERT INTO comments(threads_id,comment,from_name,dear_name,delete_key,created)VALUES(:thredsIdData,:commentData,:fromNameData,:dearNameData,:deleteKey,:created)";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':thredsIdData',$threadsId); 
            $stmh->bindValue(':fromNameData',$fromName);
            $stmh->bindValue(':dearNameData',$dearName); 
            $stmh->bindValue(':commentData',$comment);
//            $stmh->bindValue(':uniqueIdData',$uniqueId); 
            $stmh->bindValue(':deleteKey',$deleteKey); 
            $stmh->bindValue(':created',$created); 
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
          
//                if($keyData['delete_key'] === $deleteKey){
//                    $this->pdo->beginTransaction();
                    $delete ="DELETE FROM comments WHERE id = :commentsId AND delete_key = :deleteKey";
                    $stmh = $this->pdo->prepare($delete);
                    $stmh->bindValue(':commentsId',$commentsId);
                    $stmh->bindValue(':deleteKey',$deleteKey);             
                    $stmh->execute();
//                    $this->pdo->commit();
                    
                    
//                }           
                        
            }catch(PDOException $e){
//                $this->pdo->rollBack();
                echo('Error:'.$e->getMessage());
                return false;
            }
            return true;
        }  
        
    public function getThredsData($threadsId) {
        $threadsData = [];
        try{
            $threadsData = $this->pdo->prepare("select threads.id as threads_id, threads.threads_name, threads.delete_key, threads.created, comments.id as comments_id, comments.comment,  comments.unique_id, comments.from_name,comments.dear_name, comments.delete_key, comments.created from threads left join comments on (threads.id = comments.threads_id) where threads.id = :threadsId");
            $threadsData->bindValue(':threadsId',$threadsId);      
            $threadsData->execute();
            $threadsData = $threadsData->fetchAll();
        }catch(PDOException $e){
            echo('Error:'.$e->getMessage());
            return false;
        }
        return $threadsData;
        
    }
    
    
     
}
