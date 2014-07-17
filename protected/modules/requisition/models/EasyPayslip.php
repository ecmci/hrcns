<?php

/**
 * This is the model class for table "easy_payslip".
 *
 * The followings are the available columns in table 'easy_payslip':
 * @property integer $id
 * @property string $EmployeeId
 * @property string $LastName
 * @property string $FirstName
 * @property string $MiddleInitial
 * @property string $Email
 * @property string $Department
 * @property double $StdRateSalary
 * @property double $GP1
 * @property double $FICAWH
 * @property double $MedicareWH
 * @property double $FederalWH
 * @property double $StateWH
 * @property double $LocalWH
 * @property double $NetPay
 * @property double $HoursWorked
 * @property string $PayPeriod
 * @property string $Timestamp
 * @property integer $Emailed
 * @property string $LastErrorMessage
 */
class EasyPayslip extends CActiveRecord
{
  public static $smtp_servers = array(
      'evacare.com'=>array(
          'host'=>'smtp.1and1.com',
          'port'=>'25',
          'username'=>'itmanila@evacare.com',
          'password'=>'apZdtKym',
          'from'=>'steven.l@evacare.com',
          'to'=>'itmanila@evacare.com',
          'subject'=>'SMTP Healthcheck | Good | evacare.com',
          'body'=>'If you received this test email, it means smtp.1and1.com sending capability is good. This monitor runs every 1 hour.',
      ),
      'ecmci.com'=>array(
          'host'=>'mail.ecmci.com',
          'port'=>'587',
          'username'=>'itmanila@ecmci.com',
          'password'=>'qrxTdE4f',
          'from'=>'steven.l@ecmci.com',
          'to'=>'itmanila@evacare.com',
          'subject'=>'SMTP Healthcheck | Good | ecmci.com',
          'body'=>'If you received this test email, it means mail.ecmci.com sending capability is good. This monitor runs every 1 hour.',
      ),
      'eigshop.com'=>array(
          'host'=>'smtpout.secureserver.net',
          'port'=>'25',
          'username'=>'steven.l@eigshop.com',
          'password'=>'UwjM4x8S',
          'from'=>'steven.l@eigshop.com',
          'to'=>'itmanila@evacare.com',
          'subject'=>'SMTP Healthcheck | Good | eigshop.com',
          'body'=>'If you received this test email, it means smtpout.secureserver.net sending capability is good. This monitor runs every 1 hour.',
      ),
    );
  public $payrollfile;
  public static $from = array('email'=>"noreply@evacare.com",'name'=>'Pay Slip Mailer');
  public static $email_subject = "Pay Slip | [EmployeeName] | [PayPeriod]";
  public static $email_body = "
    <p>Dear Mr./Ms./Mrs. [EmployeeName],</p>
    <br/><br/>
    <p>You may now view your pay slip for [PayPeriod] at:</p>
    <p>URL: [URL]</p>
    <p>Passkey: [Passkey]</p>
    <p>Please go to the URL above and enter your passkey in order to securely access your pay slip. If you have questions or need assistance, please call (310) 889 - 9929.</p>
    <br/><br/>
    <p>Yours Truly,</p>
    <br/>
    <p>Pay Slip Emailer</p>
    <p>Eva Care Group</p>
    <p>Please do not reply to this email.</p>
  ";
  public static $baseUrl = 'http://192.168.1.231/hrips/index.php';
  
   
  
  public static function emailPaySlips(){
    $records = self::model()->findAll(array(
      'select'=>'id,passkey,FirstName,LastName,PayPeriod,Email',
      'condition'=>"isValid = '1' AND Emailed = '0'",
    )); 
    
    $themail = array();
    foreach($records as $record){
      $themail = array();
      
      $mailer = self::getMailerObject();
      
      $mailer->AddAddress($record->Email);
      
      $subject = str_replace('[EmployeeName]', $record->LastName.', '.$record->FirstName, self::$email_subject);
      $subject = str_replace('[PayPeriod]', $record->PayPeriod, $subject);      
      $mailer->Subject =  $subject;
      
      $body = str_replace('[PayPeriod]', $record->PayPeriod, self::$email_body);
      $body = str_replace('[URL]', self::$baseUrl.'/easyPayslip/viewpayslip/id/'.$record->id, $body);
      $body = str_replace('[Passkey]', $record->passkey, $body);
      $body = str_replace('[EmployeeName]', $record->LastName, $body);      
      $mailer->MsgHTML = $body;
      $mailer->Body = $body;
      try{
        if($mailer->Send()){
          echo 'EasyPaylip Emailer: Successfully sent to '.$record->Email;
          Yii::log('EasyPaylip Emailer: Successfully sent to '.$record->Email,'error','app');
        }else{
          throw new Exception('Failed to send payslip. Unknown error.');
        }
           //$mailer->Send();
      }catch(Exception $e){
        echo $e->getMessage();
        Yii::log('EasyPaylip Emailer: Error! '.$e->getMessage(),'error','app');
      }
      //echo '<pre>';print_r($body);echo '</pre>'; 
    } 
  }
  
  private static function getMailerObject(){
      Yii::import('ext.phpmailer.JPhpMailer');
      $mail = new JPhpMailer;
      $mail->IsSMTP();
      $mail->Mailer = "smtp";
      $mail->Host = self::$smtp_servers['evacare.com']['host'];
      $mail->Port = self::$smtp_servers['evacare.com']['port'];
      $mail->SMTPAuth = true;
      $mail->Username = self::$smtp_servers['evacare.com']['username'];
      $mail->Password = self::$smtp_servers['evacare.com']['password'];
      $mail->SetFrom(self::$from['email'], self::$from['name']);
      //$mail->AddAddress($server['to']);
      //$mail->Subject = $this->'subject'];
      $mail->IsHTML(true);
      //$mail->MsgHTML($server['body']);
      //$mail->Priority = '5';
      return $mail;
  }

  public function authenticate(){
    $exists = self::model()->exists("id = '$this->id' AND passkey = '$this->passkey'");
    if(!$exists)
      $this->addError('passkey',"Invalid passkey!");
    return $exists;
  }
  
  public function processPayrollFile($folder='',$filename=''){
    $success = false;
    try{
       //1. OPen the payroll file
      $file_handle = fopen($folder.'/'.$filename, "r");
      
      //2. Parse it.
      $row = 0;
      $form = new CActiveForm;
      $debug = array();
      while (!feof($file_handle) ) {
        $data = fgetcsv($file_handle, 1024);
        if($row > 0){ // first row is heading fields
          $record = new EasyPayslip('parse');
          $record->EmployeeId = $data[0];
          $record->ClientGroup = $this->ClientGroup;          
          $record->LastName = $data[1];
          $record->FirstName = $data[2];
          $record->MiddleInitial = $data[3];
          $record->Email = $data[4];
          $record->SSN = $data[5];
          $record->Department = $data[6];
          $record->StdRateSalary = $data[7];
          $record->GP1 = $data[8];
          $record->FICAWH = $data[9]; 
          $record->MedicareWH = $data[10];
          $record->FederalWH = $data[11];
          $record->StateWH = $data[12];
          $record->LocalWH = $data[13];
          $record->NetPay = $data[14];
          $record->HoursWorked = $data[15];
          $record->CheckNumber = $data[16];
          $record->PayPeriod = $this->PayPeriod;          
          $record->Emailed = 0;
          $record->isValid = $record->validate();
          $record->LastErrorMessage = $form->errorSummary($record);
          //if($record->isValid) 
          $record->save(false);
          //$debug[] = $record->LastErrorMessage;
          //if($row > 2) break; 
        }
        $row++;
      }
      
      
      //3. Close the file.
      fclose($file_handle);
      
      //echo '<pre>'; print_r($debug); echo '</pre>'; exit();
      $success = true;
    }catch(Exception $e){
      $this->addError('payrollfile',$e->getMessage());
      Yii::log('ERROR | processPayrollFile:'.$e->getMessage(),'error','app');
    }
    return $success;
  }
  
  
  
  
  
  public function getPayrollFolder(){
    $baseFolder = Yii::app()->basePath.'/../payroll/';
    if(!is_dir($baseFolder)) mkdir($baseFolder,0755);
    $payperiod = self::encodeFilename($this->PayPeriod);
    //$salt = md5(rand(1937,5524));
    $folder =  $baseFolder.''.$payperiod.'_'.date('Y_m_d_h_i_s',time());
    mkdir($folder);
    return $folder; 
  }
  
  public static function encodeFilename($file){
    return str_replace(array(',',' ','-','#'),'_',$file);
  }
  
  public function beforeSave(){
    $this->Timestamp = new CDbExpression('NOW()'); 
    $this->passkey = uniqid(); 
    return parent::beforeSave();
  }
  
  public function formatNumbers(){
      $this->StdRateSalary = number_format($this->StdRateSalary,2,'.',',');
      $this->GP1 = number_format($this->GP1,2,'.',',');
      $this->FICAWH = number_format($this->FICAWH,2,'.',','); 
      $this->MedicareWH = number_format($this->MedicareWH,2,'.',',');
      $this->FederalWH = number_format($this->FederalWH,2,'.',',');
      $this->StateWH = number_format($this->StateWH,2,'.',',');
      $this->LocalWH = number_format($this->LocalWH,2,'.',',');
      $this->NetPay = number_format($this->NetPay,2,'.',',');
      $this->HoursWorked = number_format($this->HoursWorked,2,'.',',');
  }
  
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EasyPayslip the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'easy_payslip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('EmployeeId, LastName, FirstName, MiddleInitial, Email, Department, StdRateSalary, GP1, FICAWH, MedicareWH, FederalWH, StateWH, LocalWH, NetPay, HoursWorked, ClientGroup, PayPeriod', 'required'),
      array('EmployeeId, SSN, CheckNumber, LastName, FirstName, Email, StdRateSalary, GP1, FICAWH, MedicareWH, FederalWH, StateWH, LocalWH, NetPay, HoursWorked, ClientGroup, PayPeriod', 'required','on'=>'parse'),
			array('ClientGroup, PayPeriod, payrollfile', 'required','on'=>'process'),
      array('id,passkey', 'required','on'=>'access'),
      array('id,passkey', 'safe','on'=>'access'),
      array('Email','email'),
      array('Emailed', 'numerical', 'integerOnly'=>true),
			array('StdRateSalary, GP1, FICAWH, MedicareWH, FederalWH, StateWH, LocalWH, NetPay, HoursWorked', 'numerical'),
			array('EmployeeId, LastName, FirstName, Email, Department, PayPeriod', 'length', 'max'=>512),
			array('MiddleInitial', 'length', 'max'=>3),
      //array('PayPeriod', 'match', 'not'=>true, 'pattern'=>'/[^a-zA-Z0-9]/','message'=>'Only alphanumeric characters are allowed.'),
      array('payrollfile', 'file', 'types'=>'csv','on'=>'process'),
			array('Timestamp, LastErrorMessage, payrollfile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, EmployeeId, SSN, CheckNumber, LastName, FirstName, MiddleInitial, Email, Department, StdRateSalary, GP1, FICAWH, MedicareWH, FederalWH, StateWH, LocalWH, NetPay, HoursWorked, PayPeriod, Timestamp, Emailed, LastErrorMessage, isValid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'EmployeeId' => 'Employee',
			'SSN' => 'SSN',
      'CheckNumber' => 'Check Number',
      'LastName' => 'Last Name',
			'FirstName' => 'First Name',
			'MiddleInitial' => 'Middle Initial',
			'Email' => 'Email',
			'Department' => 'Department',
			'StdRateSalary' => 'Std Rate Salary',
			'GP1' => 'Gross Pay',
			'FICAWH' => 'FICA W/H',
			'MedicareWH' => 'Medicare W/H',
			'FederalWH' => 'Federal W/H',
			'StateWH' => 'State W/H',
			'LocalWH' => 'Local W/H',
			'NetPay' => 'Net Pay',
			'HoursWorked' => 'Hours Worked',
			'PayPeriod' => 'Pay Period',
			'Timestamp' => 'Timestamp',
			'Emailed' => 'Emailed',
			'LastErrorMessage' => 'Last Error Message',
      'isValid' => 'Valid',
      'passkey' => 'Pass Key',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('EmployeeId',$this->EmployeeId,true);
    $criteria->compare('SSN',$this->SSN,true);
    $criteria->compare('CheckNumber',$this->CheckNumber,true);
		$criteria->compare('LastName',$this->LastName,true);
		$criteria->compare('FirstName',$this->FirstName,true);
		$criteria->compare('MiddleInitial',$this->MiddleInitial,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Department',$this->Department,true);
		$criteria->compare('StdRateSalary',$this->StdRateSalary);
		$criteria->compare('GP1',$this->GP1);
		$criteria->compare('FICAWH',$this->FICAWH);
		$criteria->compare('MedicareWH',$this->MedicareWH);
		$criteria->compare('FederalWH',$this->FederalWH);
		$criteria->compare('StateWH',$this->StateWH);
		$criteria->compare('LocalWH',$this->LocalWH);
		$criteria->compare('NetPay',$this->NetPay);
		$criteria->compare('HoursWorked',$this->HoursWorked);
		$criteria->compare('PayPeriod',$this->PayPeriod,true);
		$criteria->compare('Timestamp',$this->Timestamp,true);
		$criteria->compare('Emailed',$this->Emailed);
		$criteria->compare('LastErrorMessage',$this->LastErrorMessage,true);
    $criteria->compare('isValid',$this->isValid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}