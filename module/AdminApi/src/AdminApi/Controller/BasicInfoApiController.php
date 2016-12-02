<?php
namespace AdminApi\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
class BasicInfoApiController extends AbstractRestfulController
{
    public function getList()
    {

		header('Access-Control-Allow-Origin: *');
		$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$toBeAssignedCnt  = $processStatusTable->getcntOfeach('0');
		$basisinfoCnt  = $processStatusTable->getcntOfeach('1');
		$Schedulingcnt = $processStatusTable->getcntOfeach('2');
		$interviewCnt = $processStatusTable->getcntOfeach('3');
		$docsCnt = $processStatusTable->getcntOfeach('4');
		$otherDocsCnt = $processStatusTable->getcntOfeach('5');
		$preparationCnt = $processStatusTable->getcntOfeach('6');
		$synopsisCnt = $processStatusTable->getcntOfeach('7');
		$paymentCnt = $processStatusTable->getcntOfeach('8');
		$reviewCnt = $processStatusTable->getcntOfeach('9');
		$confirmationCnt = $processStatusTable->getcntOfeach('10');
		$eFiling = $processStatusTable->getcntOfeach('11');
		$paperFiling = $processStatusTable->getcntOfeach('12');
		$eCompleteFiling = $processStatusTable->getcntOfeach('13');
		$docSentFiling = $processStatusTable->getcntOfeach('14');
		$cancelFiling = $processStatusTable->getcntOfeach('15');
		if(isset($toBeAssignedCnt) && $toBeAssignedCnt>0){
			$toBeAssignedCnt = $toBeAssignedCnt;
		}else{
			$toBeAssignedCnt = 0;
		}
		if(isset($basisinfoCnt) && $basisinfoCnt>0){
			$basisinfoCnt = $basisinfoCnt;
		}else{
			$basisinfoCnt = 0;
		}
		if(isset($Schedulingcnt) && $Schedulingcnt>0){
			$Schedulingcnt = $Schedulingcnt;
		}else{
			$Schedulingcnt = 0;
		}
		if(isset($interviewCnt) && $interviewCnt>0){
			$interviewCnt = $interviewCnt;
		}else{
			$interviewCnt = 0;
		}
		if(isset($docsCnt) && $docsCnt>0){
			$docsCnt = $docsCnt;
		}else{
			$docsCnt = 0;
		}
		if(isset($otherDocsCnt) && $otherDocsCnt>0){
			$otherDocsCnt = $otherDocsCnt;
		}else{
			$otherDocsCnt = 0;
		}
		if(isset($preparationCnt) && $preparationCnt>0){
			$preparationCnt = $preparationCnt;
		}else{
			$preparationCnt = 0;
		}
		if(isset($synopsisCnt) && $synopsisCnt>0){
			$synopsisCnt = $synopsisCnt;
		}else{
			$synopsisCnt = 0;
		}
		if(isset($paymentCnt) && $paymentCnt>0){
			$paymentCnt = $paymentCnt;
		}else{
			$paymentCnt = 0;
		}
		if(isset($reviewCnt) && $reviewCnt>0){
			$reviewCnt = $reviewCnt;
		}else{
			$reviewCnt = 0;
		}
		if(isset($confirmationCnt) && $confirmationCnt>0){
			$confirmationCnt = $confirmationCnt;
		}else{
			$confirmationCnt = 0;
		}
		if(isset($eFiling) && $eFiling>0){
			$eFiling = $eFiling;
		}else{
			$eFiling = 0;
		}
		if(isset($paperFiling) && $paperFiling>0){
			$paperFiling = $paperFiling;
		}else{
			$paperFiling = 0;
		}if(isset($eCompleteFiling) && $eCompleteFiling>0){
			$eCompleteFiling = $eCompleteFiling;
		}else{
			$eCompleteFiling = 0;
		}if(isset($docSentFiling) && $docSentFiling>0){
			$docSentFiling = $docSentFiling;
		}else{
			$docSentFiling = 0;
		}if(isset($cancelFiling) && $cancelFiling>0){
			$cancelFiling = $cancelFiling;
		}else{
			$cancelFiling = 0;
		}
		return new JsonModel(array(
			'value'  => 1,
			'output'   => 'success',
			'toBeAssignedCnt' 	 => $toBeAssignedCnt,
			'basisinfoCnt' 	 => $basisinfoCnt,
			'Schedulingcnt' 	 => $Schedulingcnt,
			'interviewCnt' 	 => $interviewCnt,
			'docsCnt' 	 => $docsCnt,
			'otherDocsCnt' 	 => $otherDocsCnt,
			'preparationCnt' 	 => $preparationCnt,
			'synopsisCnt' 	 => $synopsisCnt,
			'paymentCnt' 	 => $paymentCnt,
			'reviewCnt' 	 => $reviewCnt,
			'confirmationCnt' 	 => $confirmationCnt,
			'eFiling' 	 => $eFiling,
			'paperFiling' 	 => $paperFiling,
			'eCompleteFiling' 	 => $eCompleteFiling,
			'docSentFiling' 	 => $docSentFiling,
			'cancelFiling' 	 => $cancelFiling
		));
	}
    public function get($id)
    {	
		header('Access-Control-Allow-Origin: *');
		$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$getData =array();
		if($id=='0'){
			$getData = $processStatusTable->getToassignedData($id);
		}else if($id=='1'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='2'){
			$getData = $processStatusTable->getScheduleData($id);
		}else if($id=='3'){
			$getData = $processStatusTable->getInterviewData($id);
		}else if($id=='4'){
			$getData = $processStatusTable->getDocsData($id);
		}else if($id=='5'){
			$getData = $processStatusTable->getOtherDocsData($id);
		}else if($id=='6'){
			$getData = $processStatusTable->getPreparationData($id);
		}else if($id=='7'){
			$getData = $processStatusTable->getSynopsisData($id);
		}else if($id=='8'){
			$getData = $processStatusTable->getPaymentData($id);
		}
		else if($id=='9'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='10'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='11'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='12'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='13'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='14'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}else if($id=='15'){
			$getData = $processStatusTable->getBaseInfoData($id);
		}
		$list =array();
		if(count($getData)>0){
			foreach($getData as $users){
				$list[]=$users;				
			}
			return new JsonModel(array(
				'value'  => 1,
				'output'   => 'success',
				'list' 	 => $list
			));
		}else{
			return new JsonModel(array(
				'value' 	=> 0,
				'output' 	=> 'boom',
				'list' 	   => '',
			));
		}
    }
    public function create($status)
    {
		header('Access-Control-Allow-Origin: *');		
    }
    public function update($uid,$status)
    {
		header('Access-Control-Allow-Origin: *');
		$processStatusTable = $this->getServiceLocator()->get('Models\Model\ProcessingStatusFactory');
		$commentsTable = $this->getServiceLocator()->get('Models\Model\CommentsFactory');
		$st = $status['ps_state'];
		$comment = $status['comment'];
		$updateProcessStatus = $processStatusTable->updateProcess($uid,$st);		
		if($updateProcessStatus>0){
			if(isset($_SESSION['user_id']) && $_SESSION['user_id']){
				$commttedBy = $_SESSION['user_id'];
			}
			$insertComment = $commentsTable->addComment($uid,$commttedBy,$comment);
			return new JsonModel(array(
				'output'   => 'success',
				'success'  => true
			));
		}else{
			return new JsonModel(array(
				'output'   => 'not success',
				'success'  => false
			));
		}
	}
		
    public function delete($id)
    {
       
    }
}