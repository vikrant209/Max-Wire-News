<?php include_once("header.php");?>
  <div class="body-container">
    <div class="main">
             
      <div class="section-container">
		<div class="container">
				<div class="wrapper">
					<div class="leftPart">
						<section class="ccblue margbot20">	
						<div class="mainmenu">
						  <ul>
								<li>
									<a class="mngPress"></a><h4>Manage Press Releases</h4>
								</li>
								<li>
									<a class="addPress"></a><h4>Add Press Releases</h4>
								</li>
								<li>
									<a class="ordHistory"></a><h4>Order <br/>History</h4>
								</li>
								<li>
									<a class="mngCompany"></a><h4>Manage <br/>Company</h4>
								</li>
								<li>
									<a class="pressRoom"></a><h4>Press <br/>Room</h4>
								</li>
								<li>
									<a class="editAccount"></a><h4>Edit <br/>Account</h4>
								</li>
								<li>
									<a class="SprtTicket"></a><h4>Support <br/>Ticket</h4>
								</li>
								<li>
									<a class="report"></a><h4>View<br/>report</h4>
								</li>
							</ul>
						</div>
					</section>
					</div>
					<div class="rightPart">
						<section id="prSec">
						<h1 class="marg-top10">Post Press Release</h1>
						<form class="newform">
							<p>
								<label>Title</label><input type="text" />
							</p>
							<p class="margbot0">
								<label>Summary</label><textarea></textarea>
							</p>
							
								<h2>Image</h2>
							
							<p>
								<label>Upload Image</label><input type=file name="Upload Image" />
							</p>
							<p>
								<label>Quote/Image Description</label><textarea></textarea>
							</p>
							<p class="margbot0">
							<label>&nbsp;</label>
								 <input type="checkbox" name="" value="" > <input type="checkbox" name="" value="">  <input type="checkbox" name="" value=""> <input type="checkbox" name="" value=""> 
							</p>
							<p class="margbot0">
								<label>Press Release COntent<sup>*</sup></label><textarea></textarea>
							</p>
								<h2>Category</h2>
							
							<p class="margbot0">
								<ul class="category">
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
								</ul>
								<ul class="category">
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
								</ul>
								<ul class="category">
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
									<li><input type="checkbox" /> <label>Agriculture & Farming</label></li>
									<li><input type="checkbox" /> <label>Building & Construction</label></li>
								</ul>
							</p>
							
							<p>
							<label style="font-family: 'Bitter', serif; font-size: 30px; color: #3a3a3a;">PR Type</label><select>
									<option>Select Order</option>
								</select>
							</p>
							<h2>Media Contact</h2>
							<p class="margbot0">
							<label>Company List</label>
								<select>
									<option>--Select Company Name/Or New--</option>
								</select>
							</p>
							<p><label>Company<sup>*</sup></label><input type="text" /></p>
							<p><label>Name<sup>*</sup></label><input type="text" /></p>
							<p><label>Address1</label><input type="text" /></p>
							<p><label>Address2</label><input type="text" /></p>
							<p><label>Phone<sup>*</sup></label><input type="number" /></p>
							<p><label>Email<sup>*</sup></label><input type="email" /></p>
							<p><label>City</label><input type="text" /></p>
							<p><label>State</label><input type="text" /></p>
							<p class="margbot0">
								<label>Country</label>
								<select>
									<option>--Select Company Name/Or New--</option>
								</select>
							</p>
							<p><label>Website/URL<sup>*</sup></label><input type="text" /><span>&nbsp; &nbsp; <a href="#">Verify Site</a></span></p>
							<p class="margbot0">
								<label>Also Distributable on Indian News website:</label>
								<select>
									<option>Yes</option>
								</select>
							</p>
							<p><label>Schedule/Publish on<sup>*</sup></label><input type="text" /><span> &nbsp; &nbsp;EST (Eastern Standard Time)</span></p>
							
							<h2 &nbsp; &nbsp;>Meta Tags</h2>
							
							<p><label>Title</label><input type="text" /></p>
							<p><label>Description</label>
								<textarea></textarea>
							</p>
							<p><label>Keyword</label><input type="text" /></p>
							<p><label>Hyperlink</label>
								<select>
									<option>No Follow</option>
								</select>
							</p>
							<p class="previewarea"><label>&nbsp;</label>
								<input type="text" class="inptSmall" /> <input type="submit" class="previewbtn" value="Preview" /><input type="button" class="submitbtn" value="Submit" />
							</p>
							<p>
							<label>&nbsp;</label>
							<input type="button" class="btn submitbtnBlk" value="Save as Draft" /></p>	
						</form>
					</section>
					</div>
				</div>
				
        <div class="cl"></div>
      </div>
    </div>
  </div>
  <?php include_once("footer.php");?>
