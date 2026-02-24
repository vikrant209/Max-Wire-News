<?php include_once("header.php");?>
  <div class="body-container">
    <div class="main">
             
      <div class="section-container">
        
		
		
		<div id="content-wrapper">
	<!-- internal headings -->
	<div id="main-headings">
		<h1>Confirm Payment</h1>
	</div>
	<div id="content-main">
		<div id="payment">
			<form>
				<table class="table-format prService" cellpadding="0" cellspacing="0" >
									<tbody>
										<tr class="pagehead">
											<td width="66%" colspan="2" align="left" valign="top" class="pad10">
												<strong>Payment Details</strong>
											</td>
										</tr>
										<tr>
											<td height="26" align="left" valign="top" class="pad10" style="border-bottom:1px solid #e0e0e0;">
												<h1 class="every-futr">Press Release Writing Services</h1>
												<strong>Cost Per Press Release Writing:</strong> $30
											</td>
										</tr>
										<tr class="text">
											<td align="left" valign="top" class="pad10">
												<table width="100%" cellpadding="0" cellspacing="0">
													<tr>
														<td width="60%" align="left"  style="border-right:1px solid #e0e0e0;">
															<table width="100%" border="0" cellpadding="0" cellspacing="0" class="prService2">
																<tbody>
																	<tr>
																		<td valign="middle" colspan="3" >
																			<span>Account Information</span>
																		</td>

																	</tr>
														<tr>
															<td width="10%" align="left" valign="middle">
																<strong>Name:</strong>
															</td>
															<td width="90%" colspan="2" align="left" valign="middle">
																<input type="text" name="name" class="myinpt" id="name" value="">
															</td>
														</tr>
														<tr>
															<td width="10%" align="left" valign="middle"">
																<strong>Email Id:</strong>
															</td>
															<td width="90%" colspan="2" align="left" valign="middle" >
																<input type="email" name="email" id="email" class="myinpt" value="">
																	
															</td>
														</tr>
														<tr>
															<td colspan="3" align="left" valign="middle">
																<h1 class="every-futr">Amount Information</h1>
															</td>
														</tr>
														<tr>
															<td align="left" valign="middle">
																<strong>No of Press Release Writing:</strong>
															</td>
															<td valign="middle">
																<div class="fleft">
																	<select name="no_of_pr" id="no_of_pr" class="inpt-select wid50" onChange="javascript: totalcostprli(this.value);">
																		<option value="1" selected="selected">1</option>
																		<option value="2">2</option>
																		<option value="3">3</option>
																		<option value="4">4</option>
																	</select>
																</div>
																<td align="left" colspan="2"><b>X &nbsp;$30 =  $30</b></td>
															</td>
														</tr>
														<tr>
															<td colspan="3" align="left" valign="middle">
																<span id="payable">
																	<strong>Payable Amount:</strong> $30
																</span>
															</td>
														</tr>
													</tbody>
															</table>
														</td>
														<td width="40%" align="left" rowspan="4" valign="top" class="bigtable">
															<div class="tablecontainer">
																<h3>Note: Volume discount on bulk buying</h3>
																<p>100% off for 5+ PRs</p>
																<p>100% off for 5+ PRs</p>
																<p>100% off for 5+ PRs</p>
																<p>100% off for 5+ PRs</p>
																
															</div>
														</td>
													</tr>
												</table>
													<!--	<table width="37%" class="table-format">
															<tbody>
																<tr>
																	<td>
																		<h1 class="every-futr" style="font-size:20px !important">Note: Volume discount on bulk buying</h1>
																		<br>
																			<strong>10% off for  5+ PRs
																				<br>

15% off for 10+ PRs
																					<br>
20% off for 20+ PRs
																						<br>
																						</strong>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																		-->
																	</td>
																</tr>
																<tr class="text" bgcolor="#ededed">
																	<td align="left" valign="top" bgcolor="#f2f2f2" >
																		<div class="fleft">
																			<input type="submit" name="confirm" value="Confirm" id="sub" class="submitbtn" />&nbsp;&nbsp;&nbsp;
																			<input type="submit" name="Cancel" value="Cancel" id="sub" class="resyndicate" />
																			
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
								
			</form>
		</div>
	</div>
</div>
		
		
		
		
		
		
		
		
        <div class="cl"></div>
      </div>
    </div>
  </div>
  <?php include_once("footer.php");?>