<?php

  	$accounts_account_type=array( 	
				 				1=>"Credit",
								2=>"Debit");

  	$accounts_statement_type=array(1=>"Balance Sheet",
							   2=>"Income Statement");
  	$accounts_cash_flow_group=array(1=>"Operating Activities",
								2=>"Investing Activities",
								3=>"Financing Activities",
								4=>"Cash & Cash Equivalents");
 	

	$row_status=array(
				1=>"Active",
				2=>"InActive",
				3=>"Cancelled"); 



	$party_type=array(
					1=>"Buyer",
					2=>"Subcontract",
					3=>"Buyer/Subcontract",
					4=>"Notifying Party",
					5=>"Consignee",
					6=>"Notifying/Consignee",
					20=>"Buying Agent",
					21=>"Buyer/Buying Agent",
					22=>"Export LC Applicant",
					23=>"LC Applicant/Buying Agent",
					30=>"Developing Buyer",
					90=>"Buyer/Supplier"); 
	


	$control_accounts = array(1=>"AP",
						  2=>"AR",
						  3=>"Import Payable",
						  4=>"Export Receivable",
						  5=>"Advance Paid-Supplier",
						  6=>"Advance Received-Customer",
						  7=>"Export Negotiation Liability",
						  8=>"Other Trade Finance",
						  9=>"Tax at source from Suppliers' Bill",
						  10=>"Tax at source from Sales Bill",
						  11=>"VAT at source from Suppliers' Bill",
						  12=>"VAT at source from Sales Bill",
						  13=>"Security at source from Suppliers' Bill",
						  14=>"Security at source from Sales Bill",
						  15=>"Tax at source from Employees' Salary",
						  16=>"Discount Allowed",
						  17=>"Discount Received",
						  18=>"Write-off Assets",
						  19=>"Write-off Liability",
						  20=>"Other Subsidiary",
						  21=>"Advance Paid-Employee",
						  22=>"Advance Paid-Others",
						  23=>"Advance Received-Employee",
						  24=>"Advance Received-Others");

	$account_nature = array(1=>"Cash",
						  2=>"Bank",
						  3=>"OD/CC",
						  4=>"Foreign Sales",
						  5=>"Local Sales",
						  6=>"Project Sales",
						  7=>"Purchase",
						  8=>"Project Cost",
						  9=>"Interest",
						  10=>"Bank Charges",
						  11=>"Currency Exchange Gain/Loss - Export",
						  12=>"Currency Exchange Gain/Loss - Import",
						  13=>"Project Common Cost",
						  14=>"Depreciation, Amortization & Depletion");
	$currency=array(1=>"Taka",
					2=>"USD",
					3=>"EURO");
	$yes_no=array(1=>"Yes",2=>"No");

	$accounts_main_group=array(1=>"OWNERS EQUITY",
						   2=>"NON-CURRENT LIABILITIES",
						   3=>"CURRENT LIABILITIES",
						   4=>"NON-CURRENT ASSETS",
						   5=>"CURRENT ASSETS",
						   6=>"REVENUE",
						   7=>"COST OF GOOD SOLD",
						   8=>"OPERATING EXPENSES",
						   9=>"FINANCIAL EXPENSES",
						   10=>"NON-OPERATING INCOME & EXPENSE",
						   11=>"EXTRA ORDINARY ITEMS",
						   12=>"TAX EXPENSE");

	$accounts_journal_type=array(
						   1=>"Opening/Closing Journal",
						   2=>"Credit Purchase Journal",
						   3=>"Credit Sales Journal",
						   4=>"Cash withdrawn Journal",
						   5=>"Cash Deposit Journal",
						   6=>"Cash Receive Journal",
						   7=>"Cheque Deposit Journal",
						   8=>"Cash Payment Journal",
						   9=>"Export Realization Journal",
						   10=>"Bank Payment Journal",
						   11=>"Adjustment Journal",
						   12=>"Provisional Journal",
						   13=>"Reverse Journal",
						   14=>"Rectifying Journal",
						   15=>"General Journal");

	$instrument_type = array(1=>"Bearer Cheque",
						  2=>"Crossed Cheque",
						  3=>"Pay Order",
						  4=>"TT",
						  5=>"DD",
						  6=>"Special Crossed Cheque",
						  7=>"Deposit Slip");

	$ac_loan_type = array(
						1=>"PAD",
						2=>"LTR",
						3=>"LIM",
						10=>"Packing Credit",
						11=>"ECC",
						20=>"Term Loan",
						50=>"Project Loan");
?>