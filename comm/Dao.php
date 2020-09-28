<?php

require_once 'db/PdoOne.php';
require_once 'db/PdoOneEncryption.php';
require_once 'db/Collection.php';

use eftec\PdoOne;

class Dao
{
    private $dao;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'f4g5h6j7k8!';
    private $db = 'global_db_trade';

    public function __construct()
    {
        $this->dao = new PdoOne('mysql', $this->host, $this->user, $this->pass, $this->db, "logpdoone.txt");
        try {
            $this->dao->connect();
        } catch (Exception $e) {
//            echo $e->getMessage();
//            var_dump($e->getTrace());
            echo "<h2>문제가 발생했습니다. 관리자에게 문의해주세요.</h2>";
            die(1);
        }
    }

    public function hello()
    {
        return 'hello there';
    }

    public function reqDeposit($id, $amount, $name, $type)
    {
        if ($this->dao->startTransaction()) {
            try {
                $stmp = $this->dao->prepare("INSERT INTO req_deposit (fc_id, req_amount, deposit_name, deposit_type) VALUES (?, ?, ?, ?)");
                $stmp->bindParam(1, $id, PDO::PARAM_STR);
                $stmp->bindParam(2, $amount, PDO::PARAM_INT);
                $stmp->bindParam(3, $name, PDO::PARAM_STR);
				$stmp->bindParam(4, $type, PDO::PARAM_STR);
                $stmp->execute();
                $this->dao->commit();
                return true;
            } catch (Exception $e) {
                echo $e->getTrace();
                return false;
            }
        }

        return false;
    }

    public function reqDepositList($id = '')
    {

        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        if (isset($start_date) && isset($end_date)) {
            if ($this->dao->startTransaction()) {
                try {
                    if (isset($id) && $id != '') {
//                        var_dump($start_date);
//                        var_dump($end_date);
                        $stmp = $this->dao->select('*')
                            ->from('req_deposit')
                            ->where('fc_id=?', $id)
                            ->where('req_time >= ?', $start_date)
                            ->where('req_time <= ?', $end_date)
                            ->order('req_time desc')
                            ->toList();
                        $this->dao->commit();
                        return $stmp;
                    } else {
                        $stmp = $this->dao->select('*')
                            ->where('req_time >=?', $start_date)
                            ->where('req_time <=?', $end_date)
                            ->order('req_time desc')
                            ->from('req_deposit')->toList();
                        $this->dao->commit();
                        return $stmp;
                    }

                } catch (Exception $e) {

                    var_dump($e->getTrace());

                }
            }
        } else {
            if ($this->dao->startTransaction()) {
                try {
                    if (isset($id) && $id != '') {
                        $stmp = $this->dao->select('*')
                            ->from('req_deposit')
                            ->where('fc_id=?', $id)
                            ->order('req_time desc')
                            ->toList();
                        $this->dao->commit();
                        return $stmp;
                    } else {
                        $stmp = $this->dao->select('*')
                            ->from('req_deposit')
                            ->order('req_time desc')
                            ->toList();
                        $this->dao->commit();
                        return $stmp;
                    }

                } catch (Exception $e) {
//                return 'hello';
                    return $e->getTrace();

                }
            }
        }


//        return '123123';
    }

    public function confirmDeposit($id, $amount)
    {

        if ($this->dao->startTransaction()) {
            try {
                if (isset($id) && $id != '') {
                    $this->dao->from("req_deposit")
                        ->set("check_amount=?", $amount)
                        ->where("id=?", $id)->update();
                    $this->dao->commit();
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $e) {
                return $e->getTrace();

            }
        }
    }

    public function confirmDepositRollback($id)
    {

        if ($this->dao->startTransaction()) {
            try {
                if (isset($id) && $id != '') {
                    $this->dao->from("req_deposit")
                        ->set("check_amount=null")
                        ->where("id=?", $id)->update();
                    $this->dao->commit();
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $e) {
                return $e->getTrace();

            }
        }
    }

    public function confirmAddDeposit($cid, $amount)
    {

        if ($this->dao->startTransaction()) {
            try {
                if (isset($cid) && $cid != '') {

                    $point_sum = $this->dao->select('sum(po_point)')->from('g5_point')
                        ->where('mb_id=?', $cid)
                        ->first()['sum(po_point)'];
                    $this->dao
                        ->insert('g5_point',
                            ['mb_id', 's', $cid,
                                'po_use_point', 'i', 0,
                                'po_content', 's', '입금확인',
                                'po_point', 'i', $amount,
                                'po_mb_point', 'i', $point_sum + $amount,
                                'po_expired', 'i', 0,
                                'po_datetime', 's', date('Y-m-d H:i:s', time()),
                                'po_expire_date', 's', '9999-12-31',
                                'po_rel_table', 's', 'confirm_deposit',
                                'po_rel_id', 's', $cid,
                                'po_rel_action', 's', '입금확인',
                            ]
                        );

                    $this->dao->commit();
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $e) {
                var_dump($e->getTrace());

            }
        }
    }


    public function getAllocateInfo($cid)
    {
        if ($this->dao->startTransaction()) {
            try {
                /**
                 * 최초 금액과 입력된 날짜를 먼저 가져온다
                 */
                $re = $this->dao->select("req_date, price")
                    ->from('customer')
                    ->where('id=?', $cid)->first();
                $this->dao->commit();

                return $re;
            } catch (Exception $e) {
                echo $e->getTrace();
            }
        }
        return false;
    }

    public function getPoint($id)
    {
        if ($this->dao->startTransaction()) {
            try {
                $re = $this->dao->select("sum(po_point), sum(po_use_point)")
                    ->from('g5_point')
                    ->where('mb_id=?', $id)->first();
                $this->dao->commit();
                $point = $re['sum(po_point)'] - $re['sum(po_use_point)'];
//                foreach ($re as $value){
//                    var_dump($value['po_point']);
//                    $point += ($value['po_point'] - $value['po_use_point']);
//                }
                return $point;
            } catch (Exception $e) {
                echo $e->getTrace();
            }
        }
        return false;
    }

    public function updatePrice($cid, $price)
    {
        if ($this->dao->startTransaction()) {
            try {
                /**
                 * 금액 업데이트
                 */

                $this->dao->from("customer")
                    ->set("price=?", $price)
                    ->where("id=?", $cid)->update();


                $this->dao->commit();
                return true;
            } catch (Exception $e) {
                var_dump($e->getTrace());
            }
        }
        return false;
    }

    public function confirmCancelDeploy($cid)
    {

        if ($this->dao->startTransaction()) {
            try {
                /**
                 * 금액 업데이트
                 */

                $this->dao->from("customer")
                    ->set("allocate_price=NULL")
                    ->set("allocate_date=NULL")
                    ->set("status=0")
                    ->set("allocate_fc_id=NULL")
                    ->where("id=?", $cid)->update();


                $this->dao->commit();
                return true;
            } catch (Exception $e) {
                var_dump($e->getTrace());
            }
        }
        return false;
    }

    public function getTotalInputDeposit($fid)
    {

        if ($this->dao->startTransaction()) {
            try {
                $sum = $this->dao->select('sum(req_amount)')->from('req_deposit')
                    ->where('fc_id=?', $fid)
                    ->first()['sum(req_amount)'];
                $this->dao->commit();
                return number_format($sum);
            } catch (Exception $e) {
                var_dump($e->getTrace());
            }
        }
        return 0;
    }

    public function getTotalCheckedDeposit($fid)
    {

        if ($this->dao->startTransaction()) {
            try {
                $sum = $this->dao->select('sum(check_amount)')->from('req_deposit')
                    ->where('fc_id=?', $fid)
                    ->first()['sum(check_amount)'];

                $this->dao->commit();
                return number_format($sum);
            } catch (Exception $e) {
                var_dump($e->getTrace());
            }
        }
        return 0;
    }


    public function usePoint($mid, $cid, $usePoint)
    {
        if ($this->dao->startTransaction()) {
            $usedPoint = 0;
            try {
                /**
                 * 사용 포인트 차감하고, po_use_point 에 insert 를 해야함
                 */
//                $usedPoint = $this->dao->select('po_use_point')
//                    ->from('g5_point')
//                    ->where('mb_id=?', $mid)->first();
//                if(empty($usedPoint) == false){
//                    $usedPoint = $usedPoint['po_use_point'];
//                }else{
//                    $usedPoint = 0;
//                }
//                 $this->dao->from("g5_point")
//                    ->set("po_use_point=?", $usedPoint+$usePoint)
//                    ->where("mb_id=?", $mid)->update();
                $point_sum = $this->dao->select('sum(po_point)')->from('g5_point')
                    ->where('mb_id=?', $mid)
                    ->first()['sum(po_point)'];
                $this->dao
                    ->insert('g5_point',
                        ['mb_id', 's', $mid,
                            'po_use_point', 'i', $usePoint,
                            'po_content', 's', '입금확인',
                            'po_point', 'i', 0,
                            'po_mb_point', 'i', $point_sum - $usePoint,
                            'po_expired', 'i', 0,
                            'po_datetime', 's', date('Y-m-d H:i:s', time()),
                            'po_expire_date', 's', '9999-12-31',
                            'po_rel_table', 's', 'confirm_deposit',
                            'po_rel_id', 's', $cid,
                            'po_rel_action', 's', '배정받기',
                        ]
                    );
                /**
                 *          ->from("producttype")
                 *          ->set("name=?",['s','Captain-Crunch'])
                 *          ->where('idproducttype=?',['i',6])
                 *          ->update();
                 */

                /**
                 * 어디에 썼는지도 기록한다
                 * set(['mb_id', $mid, 'use_point', $usePoint, 'customer_id', $cid ])
                 */

//                var_dump($mid);
//                var_dump($usePoint);
//                var_dump($cid);

                $this->dao
//                    set(['mb_id','s', $mid, 'use_point', 'i', $usePoint, 'customer_id', 'i', $cid])
//                    ->from('point_use_log')
                    ->insert('point_use_log',
                        ['mb_id', 's', $mid,
                            'use_point', 'i', $usePoint,
                            'customer_id', 'i', $cid]
                    );

                /**
                 *      insert('table',['col1','i','col2','s'],[10,'hello world']); // definition (binary) and value
                 */

                /**
                 * 배정 아이디도 적어놓는다. 상태도 적고, 배정일도 적는다.
                 * customer 테이블도 업데이트한다
                 * allocate_fc_id -> $mid
                 * status -> 1
                 * allocate_date -> now
                 * allocate_price -> price
                 */

                $this->dao->from("customer")
                    ->set("allocate_fc_id=?", $mid)
                    ->set("status=?", ['i', 1])
                    ->set("allocate_date=now()")
                    ->set("allocate_price=?", ['i', $usePoint])
                    ->where("id=?", $cid)->update();

                $this->dao->commit();
                return true;
            } catch (Exception $e) {
                var_dump($e->getTrace());
                if ($this->dao->startTransaction()) {
                    try {
                        $this->dao->from("g5_point")
                            ->set("po_use_point=?", $usedPoint)
                            ->where("mb_id=?", $mid)->update();
                    } catch (Exception $e) {
                    }
                }
            }
        }
        return false;
    }

    public function is_member($id)
    {
        if ($this->dao->startTransaction()) {
            try {
                $re = $this->dao->select('*')
                    ->from('g5_member')
                    ->where('mb_id=?', $id)->first();
                $this->dao->commit();
                if ($re) return true;
            } catch (Exception $e) {
                echo $e->getTrace();
            }
        }
        return false;
    }

    public function getCustomersTotalPage()
    {

        $pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1";

        $no_of_records_per_page = 20;
        $offset = ($pageNum - 1) * $no_of_records_per_page;

        if ($this->dao->startTransaction()) {
            try {
                $start_date = $_GET['start_date'];
                $end_date = $_GET['end_date'];
                $assign = $_GET['assign'];
                $sex = $_GET['sex'];
                $sido = $_GET['sido'];
                $filter = $_GET['filter'];
                $orderby = $_GET["orderby"];

                /**
                 * 개별조건
                 *
                 * $start_date = $_GET['start_date'];
                 * $end_date = $_GET['end_date'];
                 * $assign = $_GET['assign'];
                 * $sex = $_GET['sex'];
                 * $orderby = $_GET['orderby'];
                 * $sido = $_GET['sido'];
                 * $filter = $_GET['filter'];
                 */

                $total_rows = $this->dao->select('count(*)')
                    ->from('customer');


                if ($sex != null && $sex != "") {
                    $sex = $sex == "남자" ? 1 : 0;
                    $total_rows = $total_rows->where('sex=?', $sex);
                }

                if ($start_date != null && $start_date != "") {
                    $total_rows = $total_rows->where('req_visit_date >= ?', $start_date);
                }

                if ($end_date != null && $end_date != "") {
                    $total_rows = $total_rows->where('req_visit_date <= ?', $end_date);
                }

                if ($assign != null && $assign != "") {
                    if ($assign === "배정") {
                        $total_rows = $total_rows->where('allocate_fc_id is not null');
                    } else {
                        $total_rows = $total_rows->where('allocate_fc_id is null');
                    }
                }
                if ($sido != null && $sido != "") {
                    $total_rows = $total_rows->where('location = ?', $sido);
                }

                if ($filter != null && $filter != "") {
                    $total_rows = $total_rows->where('campaign = ?', $filter);
//                    var_dump('where campaign = '.$filter);
                }

                $total_rows = $total_rows
                    ->order('id desc')
                    ->first()['count(*)'];



//                $start_date = $_GET['start_date'];
//                $end_date = $_GET['end_date'];
//
//                $orderby = $_GET["orderby"];
//                if($orderby != ""){
//                    $total_rows  = $this->dao->select('count(*)')
//                        ->from('customer')
//                        ->first()['count(*)'];
//                    $total_pages = ceil($total_rows / $no_of_records_per_page);
//                }
//                }else if($start_date != ""){
//                    $total_rows  = $this->dao->select('count(*)')
//                        ->from('customer')
//                        ->where('req_date >= ?', $start_date)
//                        ->where('req_date <= ?', $end_date)
//                        ->order('id desc')
//                        ->first()['count(*)'];
//                    $total_pages = ceil($total_rows / $no_of_records_per_page);
//                } else{
//                    $total_rows  = $this->dao->select('count(*)')->from('customer')->first()['count(*)'];
//                    $total_pages = ceil($total_rows / $no_of_records_per_page);
//                }
//


//                $total_rows = $this->dao->select('count(*)')->from('customer')->first()['count(*)'];
//                var_dump($total_rows);
                $total_pages = ceil($total_rows / $no_of_records_per_page);
                $this->dao->commit();
                return $total_pages;
            } catch
            (Exception $e) {
                echo 'errr';
                try {
                    $this->dao->rollback();
                } catch (Exception $ee) {
                }
            }
        }
    }

    function getSexFilter()
    {
        $filter = $_GET["filter"] != NULL ? $_GET["filter"] : "";
        if ($filter === "성별") {
            $sex = $_GET["search"] != NULL ? $_GET["search"] : "";
            return $sex === "남" ? 1 : 0;
        } else
            return "";
    }

    function getNameFilter()
    {
        $filter = $_GET["filter"] != NULL ? $_GET["filter"] : "";
        if ($filter === "이름") {
            $name = $_GET["search"] != NULL ? $_GET["search"] : "";
            return $name;
        } else
            return "";
    }

    function getPermissionFilter()
    {
        $filter = $_GET["filter"] != NULL ? $_GET["filter"] : "";
        if ($filter === "산모교실 퍼미션") {
            $name = $_GET["filter"] != NULL ? $_GET["filter"] : "";
            return $name;
        } else
            return "";
    }


    public function getCustomers()
    {
        $pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1";

        $no_of_records_per_page = 20;
        $offset = ($pageNum - 1) * $no_of_records_per_page;

        if ($this->dao->startTransaction()) {
            try {

                $start_date = $_GET['start_date'];
                $end_date = $_GET['end_date'];
                $assign = $_GET['assign'];
                $sex = $_GET['sex'];
                $sido = $_GET['sido'];
                $filter = $_GET['filter'];
                $orderby = $_GET["orderby"];
//                if ($orderby != "") {
//                    switch ($orderby) {
//                        case "생년월일":
//                            $stmp = $this->dao->select('*')
//                                ->from('customer')
//                                ->limit($offset . ', ' . $no_of_records_per_page)
//                                ->order('birth desc')
//                                ->toList();
//                            $this->dao->commit();
//                            return $stmp;
//                            break;
//                        case "신청일":
//                            $stmp = $this->dao->select('*')
//                                ->from('customer')
//                                ->limit($offset . ', ' . $no_of_records_per_page)
//                                ->order('req_date desc')
//                                ->toList();
//                            $this->dao->commit();
//                            return $stmp;
//                            break;
//                        case "공급가격":
//                            $stmp = $this->dao->select('*')
//                                ->from('customer')
//                                ->limit($offset . ', ' . $no_of_records_per_page)
//                                ->order('price desc')
//                                ->toList();
//                            $this->dao->commit();
//                            return $stmp;
//                            break;
//                    }
//
//                } else

                {
                    $stmp = $this->dao->select('*, price - 1000*floor((unix_timestamp(now())-unix_timestamp(req_date))/(60*60*24)) as cal_price')
                        ->from('customer')
                        ;


                    /**
                     * 개별조건
                     *
                     * $start_date = $_GET['start_date'];
                     * $end_date = $_GET['end_date'];
                     * $assign = $_GET['assign'];
                     * $sex = $_GET['sex'];
                     * $orderby = $_GET['orderby'];
                     * $sido = $_GET['sido'];
                     * $filter = $_GET['filter'];
                     */

                    if ($orderby != null && $orderby != "") {
                        switch ($orderby) {
                            case "생년월일":
                                $stmp = $stmp
                                    ->order('birth desc');
                                break;
                            case "신청일":
                                $stmp = $stmp
                                    ->order('req_date desc');
                                break;
                            case "방문요청일":
                                $stmp = $stmp
                                    ->order('req_visit_date desc');
                                break;
                            case "공급가격":
                                $stmp = $stmp
                                    ->order('cal_price desc');
                                break;
                        }
                    } else {
                        $stmp = $stmp->order('id desc');
                    }


                    if ($sex != null && $sex != "") {
                        $sex = $sex == "남자" ? 1 : 0;
                        $stmp = $stmp->where('sex=?', $sex);
                    }

                    if ($start_date != null && $start_date != "") {
                        $stmp = $stmp->where('req_visit_date >= ?', $start_date);
                    }

                    if ($end_date != null && $end_date != "") {
                        $stmp = $stmp->where('req_visit_date <= ?', $end_date);
                    }

                    if ($assign != null && $assign != "") {
                        if ($assign === "배정") {
                            $stmp = $stmp->where('allocate_fc_id is not null');
                        } else {
                            $stmp = $stmp->where('allocate_fc_id is null');
                        }
                    }
                    if ($sido != null && $sido != "") {
                        $stmp = $stmp->where('location = ?', $sido);
                    }

                    if ($filter != null && $filter != "") {
                        $stmp = $stmp->where('campaign = ?', $filter);
                    }

                    $stmp = $stmp
                        ->limit($offset . ', ' . $no_of_records_per_page)
                        ->toList();
                    $this->dao->commit();
                    return $stmp;
                };


//                else if($nameSearch != "") {
//                    $condition = $nameSearch;
//                    $stmp = $this->dao->select('*')
//                        ->where('name like ?', '%' . $condition . '%')
//                        ->from('customer')
//                        ->limit($offset . ', ' . $no_of_records_per_page)
//                        ->order('id desc')
//                        ->toList();
//                    $this->dao->commit();
//                    return $stmp;
//                }else if($start_date != ""){
//                    $stmp = $this->dao->select('*')
//                        ->from('customer')
//                        ->where('req_date >= ?', $start_date)
//                        ->where('req_date <= ?', $end_date)
//                        ->limit($offset . ', ' . $no_of_records_per_page)
//                        ->order('id desc')
//                        ->toList();
//                    $this->dao->commit();
////                    var_dump($this->dao->lastQuery);
////                    var_dump($stmp);
//                    return $stmp;
//
//                }else{
//                    $stmp = $this->dao->select('*')
//                        ->from('customer')
//                        ->limit($offset.', '.$no_of_records_per_page)
//                        ->order('id desc')
//                        ->toList();
//                    $this->dao->commit();
//                    return $stmp;
//                }

            } catch
            (Exception $e) {
                var_dump($e->getTrace());
                try {
                    $this->dao->rollback();
                } catch (Exception $ee) {
                }
            }
        }
    }

    public function getAllocatedCustomers()
    {
        if ($this->dao->startTransaction()) {
            try {
                $stmp = $this->dao->
                select('*')
                    ->from('customer')
                    ->where('allocate_fc_id is not null')
                    ->toList();
                $this->dao->commit();
                return $stmp;
            } catch
            (Exception $e) {
                echo 'errr';
                try {
                    $this->dao->rollback();
                } catch (Exception $ee) {
                }
            }
        }
    }

    /**
     * 입금등록 - 입금 확인 후 포인트 변경 - 회원관리 에서
     * 입금신청자 목록 보여주기
     */


    public function setCustomer($name, $status, $location, $birth, $sex, $contact, $req_visit_date, $consult, $req_date, $price, $campaign)
    {
        //  if ($this->dao->startTransaction()) {
        try {
            $arrMax = $this->dao->select(' max(id) ')->from('customer')->where('1=1')->first();

            $maxId = $arrMax["max(id)"] + 1;
            
	
			 $stmp = $this->dao->prepare("INSERT INTO customer (id, name, status, location, birth, sex, contact, req_visit_date, consult, req_date, price, campaign) VALUES (?, ?, ?, ?, str_to_date(?,'%Y%m%d'), ?, ?, str_to_date(?,'%Y%m%d'), ?, str_to_date(?,'%Y%m%d'), ?, ?)");
                $stmp->bindParam(1, $maxId);
                $stmp->bindParam(2, $name);
                $stmp->bindParam(3, $status);
				$stmp->bindParam(4, $location);
                $stmp->bindParam(5, $birth);
                $stmp->bindParam(6, $sex);
				$stmp->bindParam(7, $contact);
                $stmp->bindParam(8, $req_visit_date);
                $stmp->bindParam(9, $consult);
				$stmp->bindParam(10, $req_date);
				$stmp->bindParam(11, $price);
				$stmp->bindParam(12, $campaign);
                $stmp->execute();

            //$this->dao->commit();
            //sleep(1);
        } catch (Exception $e) {
            var_dump($e->getTrace());
            $this->dao->rollback();
        }
        return $maxId;
    }
//	}
    //return "errr";

	public function getAllCustomers()
    {
        if ($this->dao->startTransaction()) {
            try {
                $stmp = $this->dao->
                select('*')
                    ->from('customer')
                    
                    ->toList();
                $this->dao->commit();
                return $stmp;
            } catch
            (Exception $e) {
                echo 'errr';
                try {
                    $this->dao->rollback();
                } catch (Exception $ee) {
                }
            }
        }
    }

    public function getAllFc_list(){
        if ($this->dao->startTransaction()) {
            try{
                $temp_data = $this->dao->
                    select('*')
                    ->from('g5_member')
//                    ->where('mb_level = 10' )
                    ->toList();
                $this->dao->commit();
                return $temp_data;
            }catch (ErrorException $e){
                echo 'error :'.$e;
                try {
                    $this->dao->rollback();
                } catch (Exception $ee) {
                }
            }
        }
    }

    public function setUserFC($allocate_fc_id, $campaign, $req_date, $name, $birth, $sex, $contact, $location, $req_visit_date, $price, $status){
        if($this->dao->startTransaction()){
            try{
                $stmp = $this->dao->prepare("INSERT INTO customer (allocate_fc_id, name, status, location, birth, sex, contact, req_visit_date, req_date, price, campaign, consult) 
                                                VALUES (?, ?, ?, ?, str_to_date(?,'%Y-%m-%d'), ?, ?, str_to_date(?,'%Y-%m-%d'), str_to_date(?,'%Y-%m-%d'), ?, ?, ?)");
                $consult = 'AABB';

                $stmp->bindParam(1, $allocate_fc_id, PDO::PARAM_STR);
                $stmp->bindParam(2, $name, PDO::PARAM_STR);
                $stmp->bindParam(3, $status, PDO::PARAM_INT);
                $stmp->bindParam(4, $location, PDO::PARAM_STR);
                $stmp->bindParam(5, $birth, PDO::PARAM_STR);
                $stmp->bindParam(6, $sex, PDO::PARAM_INT);
                $stmp->bindParam(7, $contact, PDO::PARAM_STR);
                $stmp->bindParam(8, $req_visit_date, PDO::PARAM_STR);
                $stmp->bindParam(9, $req_date, PDO::PARAM_STR);
                $stmp->bindParam(10, $price, PDO::PARAM_INT);
                $stmp->bindParam(11, $campaign, PDO::PARAM_STR);
                $stmp->bindParam(12, $consult, PDO::PARAM_STR);
                $stmp->execute();
                $this->dao->commit();
                return true;
            }catch (ErrorException $e){
                return $e->getTrace();
            }
        }
    }

    public function getUser($customer_id){
        if($this->dao->startTransaction()){
            try{
                $temp_data = $this->dao->
                    select('*')
                    ->from('customer')
                    ->where('id = ? ', $customer_id)
                    ->first();
                $this->dao->commit();
                return $temp_data;
            }catch (ErrorException $e){
                echo $e->getTrace();
            }
        }
    }

    /**
     * 상세페이지에서 정보 업데이트
     */
    public function update_customer_info($id, $campaign, $req_date, $mb_job, $mb_addr1 , $mb_addr2 , $mb_memo, $mb_request_memo){

        if ($this->dao->startTransaction()) {
            try {
                $this->dao->from("customer")
                    ->set('campaign = ?' , $campaign)
                    ->set('req_date = ?' , $req_date)
                    ->set('mb_job = ?' , $mb_job)
                    ->set('mb_addr1 = ?' , $mb_addr1)
                    ->set('mb_addr2 = ?' , $mb_addr2)

                    ->set('mb_memo = ?' , $mb_memo)
                    ->set('mb_request_memo = ?' , $mb_request_memo)

//                    이름 , 생일 , 성별 , 핸드폰
//                    ->set('name = ?' , name)
//                    ->set('birth = ?' , birth)
//                    ->set('sex = ?' , sex)
//                    ->set('contact = ?' , contact)

                    ->where('id = ? ', $id)->update();

                $this->dao->commit();
                return true;
            } catch (Exception $e) {
                var_dump($e->getTrace());
            }
        }
    }

    /**
     * fc 엑셀 업로드 중복 체크
     */
    public function is_customer($name , $sex , $contact, $req_date , $campaign){

        if ($this->dao->startTransaction()) {
            try {
                $re = $this->dao->select('*')
                    ->from('customer')
                    ->where('name=?', $name)
                    ->where('sex=?', $sex)
                    ->where('contact=?', $contact)
                    ->where('substr(req_date, 1,10) =?', $req_date)
                    ->where('campaign=?', $campaign)
                    ->first();
                $this->dao->commit();
                if ($re) return true;
            } catch (Exception $e) {
                echo $e->getTrace();
            }
        }
        return false;
    }
}
