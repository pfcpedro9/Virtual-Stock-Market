<?
$db=mysql_connect("192.168.36.253","equitypulse","earth");
mysql_select_db("equitypulse",$db);

$query="select * from data where flag=1";
$result=mysql_query($query) or die("Error please start the execution again");
//this processing is only for the person who wanna sell
while ($row=mysql_fetch_array($result))
{
	$comp=$row['company'];
	$ac_price=$row['last_price'];
	//if a person is willing to sell at price what is the current index

	$query1="select * from portfolio where Company='$comp'";
	$result1=mysql_query($query1) or die ("ERROR !! please start the EXecution again");

	while ($row1=mysql_fetch_array($result1))
	{
		$login=$row1['login'];
		$tid=$row1['Tid'];
		//get the profile of the person to see whether the person has enough balance left

		$query2="select * from Login_Portfolio where login='$login'";
		$result2=mysql_query($query2) or die("Error please start the execution again");


		if ($row2=mysql_fetch_array($result2))
		{

			$cash=$row2['Cash'];
			$account_value=$row2['Account_value'];
			$shares=$row1['Shares'];

			//if the person wants to sell then add the price obtained to his cash
			if ($row1['Buy_Sell_Keep']==2)
			{
			////////////////////////////////////
			//login wants to sell shares
			///////////////////////////////////
			// now only HIGH specified
			///////////////////////////////////
				if ($row1['Higher_Price'] <= $ac_price)
//				if ($row1['Lower_Price'] >= $ac_price || $row1['Higher_Price'] <= $ac_price)
				{
					$val_of_transaction = $ac_price * $shares * 0.999;	
					$query3="delete from portfolio where Tid='$row1[Tid]'";
					mysql_query($query3) or die ("Could not delet $row1[Tid] from portfolio");
					$cash=$cash + $val_of_transaction;
					//Account value will also change
					$query3="update Login_Portfolio set Cash='$cash' where login='$login'";
					mysql_query($query3) or die ("Could not update the cash in login ");
					$query4 = "select * from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=0";
					$result4 = mysql_query($query4) or die(" could not execute");
					$row4 = mysql_fetch_array($result4);
					$share_left = $row4['Shares'] - $shares;
#					echo "login".$row4['login'].'\n'."company".$comp.'\n';
					echo "share left = ".$share_left.'\n';
#					echo "have share".$row4['Shares'].'\n';
#					echo "share will sell ".$shares.'\n';
					if($share_left>0){
						$query5="update portfolio set Shares=$share_left where login='$login' and Company='$comp' and Buy_Sell_Keep=0";
						mysql_query($query5) or die("cannot execute");
						}
					////////////////////////////////////////
					//BUG CORRECTED BELOW by adding else loop
					///////////////////////////////////////
					else
					{
						$query6="delete from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=0";
						mysql_query($query6) or die("cannot execute");
					}

					/* Eqp 07 Log for selling shares */
					$status = "Sold";
					$comment = "";
					
					create_log($login, $comp, $shares, $status, $ac_price, '0.0', '0.0', $comment);

					/* Log ends here */
					
				}
				
				else
				{
					$cash_value=$shares * $ac_price;
					$query3="update portfolio set Cash_Value='$cash_value' where Tid='$row1[Tid]'";
					mysql_query($query3) or die ("Could not update the cash in login ");

				}

			}
			elseif ($row1['Buy_Sell_Keep'] == 1)
			{
			////////////////////////////////////
			//login wants to buy shares
			////////////////////////////////////
				//echo "hi how are you ia m here";
				if ($row1['Lower_Price'] >= $ac_price)
				{
					$val_of_buying = $ac_price * $row1['Shares'] * 1.001;
					if ($val_of_buying <= $cash)
					{
						$cash=$cash - $val_of_buying;
						$cash_value=$ac_price*$shares;
						$query3="select * from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=0";
						$result3=mysql_query($query3)or die ("Error please try again");
						if ($row3=mysql_fetch_array($result3))
						{
							//echo "hi folks how are u";
							//echo "now the shares are $row3[Shares]\n";
							//So need to take average price

							$old_num_shares = $row3['Shares'];
							$old_share_price = $row3['Cost_Price'];
							$total_no_of_shares = $row1['Shares'] + $old_num_shares;

							$av_price = (($old_num_shares*$old_share_price)+($row1['Shares']*$ac_price))/($total_no_of_shares);


							$cash_value = $av_price * $total_no_of_shares;


		//					$shares = $row1['Shares'] + $row3['Shares'];
		//					$cash_value = $shares * $ac_price;
							$query3="delete from portfolio where Tid='$tid'";
							mysql_query($query3) or die ("Cannot execute the query please try again");
							//echo "NOTE the total shares is $shares\n";
							$query3 = "update portfolio set Shares='$total_no_of_shares',  Cash_Value='$cash_value',Cost_Price='$av_price' where Tid='$row3[Tid]'";
							mysql_query($query3) or die ("Cannot execute the query1");


//							$query3="select * from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=0";
//							$result3=mysql_query($query3)or die ("Error please try again");
//							if ($row3=mysql_fetch_array($result3))
//							{
								//		echo "NOW the current situation is $row3[Shares]\n";
//							}


						}
						
						else
						{
							$query3="update portfolio set Buy_Sell_Keep=0, Cash_Value='$cash_value',Lower_Price='0.0', Higher_Price='0.0',Cost_Price='$ac_price' where Tid='$row1[Tid]'";
							mysql_query($query3) or die ("Could not elete $row1[Tid] from portfolio");
						}
						$query3="update Login_Portfolio set Cash='$cash' where login='$login'";
						mysql_query($query3) or die ("Could not update the cash in login ");

						/* Eqp 07 log for buying shares */
						$status = "Bought";
						$comment = "";
						create_log($login, $comp, $shares, $status, $ac_price, '0.0', '0.0', $comment);
						//Log ends here
					}
					
					else
					{
						//convert shares into int
						$shares=intval($row2['Cash']/(1.001 * $ac_price));
						if ($shares > 0)
						{
							$shares_left=$row1['Shares'] - $shares;
							$cash=$cash-($shares * 1.001 * $ac_price);

							$query3="Select * from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=0";
							$result3=mysql_query($query3) or die ("Cannot execute the query2");
							if ($row3=mysql_fetch_array($result3))
							{

								$old_num_shares = $row3['Shares'];
								$old_share_price = $row3['Cost_Price'];
								$total_no_of_shares = $shares + $old_num_shares;

								$av_price = (($old_num_shares*$old_share_price)+($shares*$ac_price))/($total_no_of_shares);


								$cash_value = $av_price * $total_no_of_shares;




//								$shares=$shares+$row3['Shares'];
//								$cash_value=$shares*$ac_price;
								$query3="update portfolio set Shares='$total_no_of_shares', Cash_Value=$cash_value, Cost_Price='$av_price' where Tid=$row3[Tid]";
								mysql_query($query3)or die ("cannot execute the query please try again");
							}
							
							else
							{
								$cash_value = $shares * $ac_price;
								$query3="insert into portfolio (Tid,login,Company,Shares,Buy_SEll_Keep,Lower_Price,Higher_Price,Cash_Value,Cost_Price) values ('','$login','$comp','$shares',0,'0.0','0.0','$cash_value','$ac_price')";

								mysql_query($query3) or die ("Could not insert into portfolio");
							}
							
							$cash_value=$shares_left*$ac_price;
							$query3="update portfolio set Shares='$shares_left', Cash_Value='$cash_value',Cost_Price='$ac_price' where  Tid='$tid'";
							mysql_query($query3) or die ("Could not update portfolio");

							$query3="update Login_Portfolio set Cash='$cash' where login='$login'";
							mysql_query($query3) or die ("Could not update the cash in login ");

							/*Eqp 07 Log for buying shares*/

							$status = "Bought";
							$comment = "";
							
							create_log($login, $comp, $shares , $status, $ac_price, '0.0', '0.0', $comment);
							//Log ends here
						}				

					}
				}
			}
			if ($row1['Buy_Sell_Keep']==0)
			{
				//keep stocks
					$cash_value=$shares * $ac_price;
					$query3="update portfolio set Cash_Value='$cash_value' where Tid='$tid'";
					mysql_query($query3) or die ("cannot execute the transactions");
			}
			else if ($row1['Buy_Sell_Keep']==6)
			{
				////////////////////////////////////////////////////////////////////////
				//if possible cover the short sold shares which are in 'will cover' status
				////////////////////////////////////////////////////////////////////////
								
				///////////////////////////////////////////
				//CHECK THIS below
				///////////////////////////////////////////
				if($row1['Lower_Price'] == 0)	{
					$_SESSION["ep_mesg"] = "You have to specify the low price for a Cover";					
				}
				else
				{

					//Why is th Sum being used ??? in the query2 ; query3 is justified	
					//suppose the person $loginname is interested in sellling the shares
					$query2 = "Select Sum(Shares),Cost_Price from portfolio where login='$login' and Buy_Sell_Keep='4' and Company='$comp' group by login";
					$result2 = mysql_query($query2) or die ("Cannot execute the query");
					$row2 = mysql_fetch_row($result2);
						
					$shares_short_sold = $row2[0];
					if (($shares >=0 ) && ($row1['Lower_Price'] >= $ac_price))      //Cover all no_of_shares
					{
						//how much will the person get for transaction
						//row2[1] is averaging price
						$val_of_transaction = (2*$shares*$row2[1]) - ($ac_price * $shares) ;
						$query_delete="delete from portfolio where Tid='$row1[Tid]'";
						mysql_query($query_delete) or die ("Could no delete $row1[Tid] from portfolio");
						$cash = $cash + $val_of_transaction;
						//Account value will also change
						$query3="update Login_Portfolio set Cash='$cash' where login='$login'";
						mysql_query($query3) or die ("Could not update the cash in login ");
						$shares_left= $shares_short_sold - $shares;
						/*Eqp 07 Log for selling shares*/
						$status = "Covered";
						$comment = "";
						
						create_log ($login,$comp,$shares,$status,$ac_price,'0.0','0.0',$comment);
						/*Log Ends here*/
						
						if ($shares_left > 0) /*have 100 share will sell 30 share , sold another 20 share . now share i have must be 80 */
						{
							$cash_value = (2*$shares_left*$row2[1]) - ($ac_price * $shares_left);
							$query3="update portfolio set Shares='$shares_left',Cash_Value='$cash_value' where login='$login' and Company='$comp' and Buy_Sell_Keep=4";
							mysql_query($query3) or die ("Cannot execute the transaction");
						}
						
						else
						{
							$query3="delete from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=4";
							mysql_query($query3) or die ("Cannot execute the transaction");
						}					
							//-------------------------------------------------------------------------------------------------------------                 remember u have to put it in the company and in the short_sell_portfolio-----------------------------------------------------------------------------------------------------------------------
					}
					
					else
					{
						//if cover later then update cash value for short sold shares
						$cash_value = (2*$shares*$row2[1]) - ($ac_price * $shares) ;
						$query3="update portfolio set Cash_Value='$cash_value' where Tid='$row1[Tid]'";
						mysql_query($query3) or die ("Could not update the cash in login ");
					}
				
				}
			}
			else if ($row1['Buy_Sell_Keep']==5)
			{
				////////////////////////////////////////////////////////////////
				//if possible short sell the shares in 'will short sell' status
				///////////////////////////////////////////////////////////////
				$no_to_short_sell=$row1['Shares'];	
				
				//Safely can do Short-Sell at this price
				if ($row1['Higher_Price']<= $ac_price)
				{
					// val_of_selling is the transaction amount of Short-Sell 
					$val_of_selling = $ac_price * $no_to_short_sell * 1.001;
					//check whether he can buy all the shares or not
					if ($val_of_selling <= $cash)
					{
						$query3="select * from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=4";
						$result3=mysql_query($query3) or die ("Cannot execute the query");
						
						if ($row3=mysql_fetch_array($result3)) 
						{
							//echo "U already have sold it<br>"; 
							//So I am going to take the average of prices
							$old_no_of_shares = $row3['Shares'];
							$old_price = $row3['Cost_Price'];
							$total_no_of_shares = $old_no_of_shares + $no_to_short_sell;
							$avg_price = (($old_no_of_shares * $old_price) + ($no_to_short_sell * $ac_price))/($total_no_of_shares);
							$query_delete="delete from portfolio where Tid='$tid'";
							mysql_query($query_delete) or die ("Cannot execute the query please try again");
							
				//				$no_of_shares = $no_of_shares + $row3['Shares'];
							$cash_value = $ac_price * $total_no_of_shares;
				//Should I add the cash_Value.............I am adding now
							$query3 = "update portfolio set Shares='$total_no_of_shares', Cost_Price='$avg_price',Cash_Value='$cash_value' where Tid='$row3[Tid]'";
							mysql_query($query3) or die ("Error11 in exectution of the operation");
						}
						
						else
						{
							//echo "so you think you have it u jerk<br>";
							$cash_value = $ac_price * $no_to_short_sell;
							$query3 = "update portfolio set Buy_Sell_Keep=4, Cash_Value='$cash_value', Cost_Price='$ac_price', Lower_Price='0.0', Higher_Price='0.0' where Tid='$tid'";
								mysql_query($query3) or die ("Error22 in exectution of the operation");
						}
						//echo "Inserted ur transaction in the database<br>";
						//let him keep the shares as he has purchased it
						$cash = $cash - $val_of_selling;
						$query3="update Login_Portfolio set Cash='$cash' where login='$login' ";
						mysql_query($query3) or die ("Could not update the cash in login ");
						//update the login_portfolio with the current cash i.e. after deducting the expenditure
						//Eqp 07 Create  a log for the bought share
						$status = "ShortSold";
						$comment = "";
						create_log($login,$comp,$no_to_short_sell,$status,$ac_price,'0.0','0.0',$comment);
					}
					/////////////////////////////////////////////////////////////////////////////////////
					else
					{
						//suppose he cannot sell all the shares now, i.e. cash is not enough to shortsell all the shares
						//convert shares into int
						$can_shares = intval($cash / (1.001 * $ac_price));     //this many i can sell safely
						$shares_left = $no_to_short_sell - $can_shares;				// this many left pending
						$cash = $cash - ($can_shares * 1.001 * $ac_price);
				// chk the next line carefully....
						$cash_value = $can_shares * $ac_price;
						
						//insert as many shares as he can ShortSell
						if ($can_shares > 0)
						{
							$query3 = "select * from portfolio where login='$login' and Company='$comp' and Buy_Sell_Keep=4";
							$result3 = mysql_query($query3) or die ("Cannot execute the query");
							if ($row3 = mysql_fetch_array($result3)) 
							{
								$old_no_of_shares = $row3['Shares'];
								$old_price = $row3['Cost_Price'];
								$total_no_of_shares = $old_no_of_shares + $can_shares;
								$avg_price = (($old_no_of_shares * $old_price) + ($can_shares * $ac_price))/($total_no_of_shares);
								$cash_value = $total_no_of_shares * $ac_price;
						//			$shares = $shares + $row3['Shares'];
								$query3 = "update portfolio set Shares='$total_no_of_shares', Cost_Price='$avg_price' ,Cash_Value='$cash_value' where Tid='$row3[Tid]'";
								mysql_query($query3) or die ("Error33 in exectution of the operation");
							}
							
							else
							{
								$query3="insert into portfolio (Tid,login,Company,Shares,Buy_SEll_Keep,Lower_Price,Higher_Price,Cash_Value,Cost_Price) values ('','$login','$comp','$can_shares',4,'0.0','0.0',$cash_value,$ac_price)";
								mysql_query($query3) or die ("Could not insert into short_sell_portfolio");
							}
						
						
						//insert shares_left as he is interested in buying but is out of cash
						$query3="update portfolio set Shares='$shares_left' where  Tid='$tid'";
						mysql_query($query3) or die ("Could not update short_sell_portfolio");



//-------------------------------------------------------------------------------------------------------------------------------
						// update the cash value in login_short_sell_portfolio of thee

                                                        $cash_value=$shares_left*$ac_price;
//---------------------------------------------------------------------------
						$query3="update Login_Portfolio set Cash='$cash' where login='$login'";
						mysql_query($query3) or die ("Could not update the cash in login ");
							/*Eqp 07 Log for buying shares*/
						
							$status = "ShortSold";
							$comment = "";
							//////////////////////////////////////
							//BUG
							//////////////////////////////////////
							create_log($login,$comp,$can_shares,$status,$ac_price,'0.0','0.0',$comment);

						////////////////////////////////////
						//NOTE 2ND LOG FOR WILL SHORT SELL HERE
						///////////////////////////////////
							$status = "Will ShortSell";
						$comment = "Waiting";
						create_log($login,$comp,$shares_left,$status,$ac_price,$row1['Higher_Price'],'0.0',$comment);
						}


						/*Log ends here*/
					}
				}
				else
				{
					//need not update any cash value
					;
				}
			}
			else 
			{
				if ($row1['Buy_Sell_Keep']==4)
				{
					//////////////////////////////////////////////////
					// update cash_value for 'short sold' shares
					//////////////////////////////////////////////////
					$cash_value=(2*$row1['Cost_Price']*$shares)-($shares * $ac_price);
					$query3="update portfolio set Cash_Value='$cash_value' where Tid='$tid'";
					mysql_query($query3) or die ("cannot execute the transactions");
				}
			}

		}

	}
}

//updating account value for all users.....UPDATED METHOD.
$query="select * from Login_Portfolio";
$result=mysql_query($query) or die ("Could not update account value");
//$result=mysql_query($query) or die ("Please try again");
while ($row=mysql_fetch_row($result))
{
	$login=$row[0];
	//check the case when either of cash value for BUy_Sell_Keep = 0 or 4 is null or '' i guess
	$query_normal="select sum(Cash_Value) from portfolio where login='$login' and Buy_Sell_Keep=0 group by login";
	$result_normal=mysql_query($query_normal) or die ("Error please start the execution again");
	$row_normal=mysql_fetch_row($result_normal);

	$query_short="select sum(Cash_Value) from portfolio where login='$login' and Buy_Sell_Keep=4 group by login";
	$result_short=mysql_query($query_short) or die ("Error please start the execution again");
	$row_short=mysql_fetch_row($result_short);

	$account_val=$row[2] + $row_normal[0] + $row_short[0];

	$query1="update Login_Portfolio set Account_value='$account_val' where login='$login'";
	$result1=mysql_query($query1) or die("Error please start the execution again");
}




/*
//now evaluate the value of cash the person has
//this processin is only for the person who wanna sell

$query="select sum(Cash_Value),portfolio.login,Cash,Account_value from Login_Portfolio, portfolio where portfolio.login=Login_Portfolio.login and portfolio.Buy_Sell_Keep=0 group by portfolio.login";

//$query1="select sum(Cash_Value),portfolio.login,Cash,Account_value from Login_Portfolio, portfolio where portfolio.login=Login_Portfolio.login and portfolio.Buy_Sell_Keep=4 group by portfolio.login";



// $query="select sum(Cash_Value),portfolio.login,Cash,Account_value from Login_Portfolio, portfolio where portfolio.login=Login_Portfolio.login group by portfolio.login";
$result=mysql_query($query) or die ("Please try again");

while ($row=mysql_fetch_row($result))
{
	$row2[0]=0;
	$query2="select sum(Cash_Value), portfolio.login,Cash,Account_value from Login_Portfolio, portfolio where portfolio.login=Login_Portfolio.login and portfolio.login='$row[1]' and portfolio.Buy_sell_Keep=4 group by portfolio.login";
	$result2=mysql_query($query2) or die("Error please start the execution again");
	$row2=mysql_fetch_row($result2);
	$account_value=$row[0]+$row[2]+$row2[0];
	$login=$row[1];
	$query1="update Login_Portfolio set Account_value='$account_value' where login='$login'";
	$result1=mysql_query($query1) or die("Error please start the execution again");
}
*/

/* Eqp 07 code for logging
   Date: Thu, Feb 7, 2007
*/
function create_log($loginname,$Company,$Shares,$Status,$Cash_value,$High_price,$Low_price,$Comment)
{
	$query_user="select Cash, Rank from Login_Portfolio where login='$loginname'";
	$result_user=mysql_query($query_user);
	$row_user=mysql_fetch_array($result_user);
	$log_query="insert into Log values ('','$loginname','$Company',$Shares,'$Status',$Cash_value,					$High_price,$Low_price,$row_user[Cash],'$Comment',$row_user[Rank],CURTIME(),CURDATE())";
	$log_result=mysql_query($log_query) or die("could not access");
}
//Eqp 07 code ends here

mysql_close($db);

?>
