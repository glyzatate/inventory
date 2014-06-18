<?php
class Staff{
	
	var $db;
	protected $info = array();
	
	function __construct($db){
		$this->db = $db;
	}
	
	function getUserInfo() {
		if( isset($_SESSION['u']) && isset($_SESSION['uid'])){
			$result = $this->db->selectSingleQueryArray("users", 
				array("userID", "username","firstName","lastName","middleName", "email", "active", "userType_fk", "is_admin", "is_HR", "is_editing", "is_finance", "userTypeName", "supervisor", "deptName", "deptID_fk", "start_date", "leave_credits", "leave_credits_old", "title", "location"), 
				"username='{$_SESSION['u']}' AND userID='{$_SESSION['uid']}' AND active = 1",
				"LEFT JOIN userType ON userType=userType_fk LEFT JOIN departments ON deptID=deptID_fk");
				
			if($result >= 1 && $result['username'] == $_SESSION['u'] ){
				$this->info = $result;
				return true;
			}
		}
	}
	
	function getUID() {return $this->info['userID'];}
	function getUsername() {return $this->info['username'];}
	function getFirstName() {return $this->info['firstName'];}
	function getLastName() {return $this->info['lastName'];}	
	function getMiddleName() {return $this->info['middleName'];}
	function is_active() {return $this->info['active'];}
	function getDeptNum() {return $this->info['deptID_fk'];}
	function getUserType() {return $this->info['userType_fk'];}
	function getUserTypeName() {return $this->info['userTypeName'];}
	function getDept() {return $this->info['deptName'];}
	function isSuperAdmin() {return $this->info['is_admin'];}
	function isHRAdmin() {return $this->info['is_HR'];}
	function isEditingAdmin() {return $this->info['is_editing'];}
	function isFinanceAdmin() {return $this->info['is_finance'];}
	function getStartDate() {return $this->info['start_date'];}
	function getLeaveCredits() {return $this->info['leave_credits'];}
	function getLeaveCreditsOld() {return $this->info['leave_credits_old'];}
	function getTitle() {return $this->info['title'];}
	function getSupervisorID() {return $this->info['supervisor'];}
	function getLocation() {return $this->info['location'];}
		
	function getFullName() {return $this->info['firstName'].' '.$this->info['middleName'].' '.$this->info['lastName'];}
	
	/**
		$sup_id = supervisor id,
		$type = user type 
	**/
	function getAllSupervisors( $sup_id, $type ){
		$res = array();
		
		$add_q = '';
		if( $type > 5 )
			$add_q = "AND deptID_fk={$this->getDeptNum()} ";
			
			
		$result = $this->db->selectQuery("users", "userID, CONCAT( firstName, ' ', lastName) AS supName, userType_fk, supervisor", "userType_fk < {$type} {$add_q} ORDER BY userType_fk" );
				
		$uType = '';
		foreach($result AS $r):
			if($r['userID'] == $sup_id){ 
				$uType = $r['userType_fk'];
				$sup = $r['supervisor'];
			}		
		endforeach;
		
		
		if($uType!=''){
			foreach($result AS $rr){
				if( $rr['userType_fk'] < $uType || ( $rr['userType_fk'] == $uType && $rr['userID']==$sup_id ) ){
					$res[] = $rr;
				} 
			}
		}
		return $res;
				
	}
	
	
	function getImmediateSupervisor(){
		$add_q = '';
		if( $this->getUserType() > 5 )
			$add_q = "AND userType_fk < {$this->getUserType()} AND deptID_fk={$this->getDeptNum()}";
		else if( $this->getUserType() <= 5 )
			$add_q = "AND userType_fk = 3";
			
		$result = $this->db->selectQuery("users", "userID, CONCAT( firstName, ' ', lastName) AS approver, userType_fk", "userType_fk < {$this->getUserType()} {$add_q} ORDER BY userType_fk" );
		
		$approver = array();
		if(	count($result) > 0 ){
			foreach( $result AS $r ):			
				$approver[] = $r;				
			endforeach; 
			
			return $approver;
		}				
		else
			return 'None';
	}
	
	function getImmediateSupervisorByID($userType, $dept){
		$add_q = '';
		if( $userType > 5 )
			$add_q = "AND userType_fk < {$userType} AND deptID_fk={$dept}";
		else if( $userType <= 5 )
			$add_q = "AND userType_fk = 3";
			
		$result = $this->db->selectQuery("users", "userID, CONCAT( firstName, ' ', lastName) AS approver, userType_fk", "userType_fk < {$userType} {$add_q} ORDER BY userType_fk" );
		
		$approver = array();
		if(	count($result) > 0 ){
			foreach( $result AS $r ):			
				$approver[] = $r;			
			endforeach; 
			
			return $approver;
		}				
		else
			return 'None';
	}
	
	function getUserNameByID( $id ){
		$result = $this->db->selectSingleQueryArray("users", "firstName, lastName" , "userID = $id");
		return $result['firstName'].' '.$result['lastName'];
	
	}
	
	function getUserField( $id, $field){
		$result = $this->db->selectSingleQueryArray("users", $field , "userID = $id");
		return $result[$field];
	}
	
	
	
	
	
}
?>