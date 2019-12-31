
<div class="content-wrapper">

	<section class="content-header">
		<h1>Edit Client <?php echo $client_data['company_name']; ?> (<?php echo $client_data['trn']; ?>)</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('client') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Client</li>
		</ol>
	</section>


	


<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                       Tab section                                               -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


  <section class="content">
      <ul class="nav nav-tabs">
        <li class="<?php echo (($active_tab === 'client') ? 'active' : '') ?>"><a data-toggle="tab" href="#client">Client</a></li>
		<li class="<?php echo (($active_tab === 'consultation') ? 'active' : '') ?>"><a data-toggle="tab" href="#consultation">Consultation</a></li>		
		<li class="<?php echo (($active_tab === 'inquiry') ? 'active' : '') ?>"><a data-toggle="tab" href="#inquiry">Inquiry</a></li>
		<li class="<?php echo (($active_tab === 'document') ? 'active' : '') ?>"><a data-toggle="tab" href="#document">Document</a></li>
      </ul>	




<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                             Error messages generated by the submit                              -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


		<div class="row">
			<div class="col-md-12 col-xs-12">

				<div id="messages"></div>

				<?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
				<?php elseif($this->session->flashdata('error')): ?>
					<div class="alert alert-error alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
				<?php elseif($this->session->flashdata('warning')): ?>
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('warning'); ?>
					</div>
				<?php endif; ?>

				<div class="tab-content">


<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        Session variables                                        -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


		<!-- Creation of a session field to keep the client, register id and the directory -->
		<?php $this->session->unset_userdata('client_id');?>
		<?php if(empty($this->session->userdata('client_id'))) {
			$client_id = array('client_id' => $client_data['id']);
			$this->session->set_userdata($client_id);} ?>

		<!-- Creation of a session to keep the directory for the manipulation
              of upload of documents -->

        <?php $this->session->unset_userdata('directory');?>
        <?php if(empty($this->session->userdata('directory'))) {
                $directory = array('directory' => '/upload/documents/'.$client_data['directory'].'/');
                $this->session->set_userdata($directory);
    			} ?>






<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        C L I E N T                                              -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


    <div id="client" class="tab-pane fade <?php echo (($active_tab === 'client') ? 'in active' : '') ?>">	


			<div class="box">
				<form role="form" action="<?php base_url('client/update') ?>" method="post" enctype="multipart/form-data">

				<div class="box-body">

					<?php echo validation_errors(); ?>

					<!-- /row divide by 3-->
					<div class="row">

						 <div class="col-md-2 col-xs-2">
							<div class="form-group">
								<label for="trn">TRN <font color="red">*</font></label>
								<input type="text" class="form-control" id="trn" name="trn" autocomplete="off"
								value="<?php echo set_value('trn', isset($client_data['trn']) ? $client_data['trn'] : ''); ?>" />
								<input type="hidden" id="directory" name="directory" value=<?php echo $client_data['directory']; ?> />
							 </div>
						 </div>

						 <div class="col-md-5 col-xs-5">
							<div class="form-group">
								<label for="company_name">Company Name <font color="red">*</font></label>
								<input type="text" class="form-control" id="company_name" name="company_name" autocomplete="off"
								value="<?php echo set_value('company_name', isset($client_data['company_name']) ? $client_data['company_name'] : ''); ?>"/>
							</div>
						</div>

						<div class="col-md-3 col-xs-3">
							<div class="form-group">
								<label for="client_name">Client Name <font color="red">*</font></label>
								<input type="text" class="form-control" id="client_name" name="client_name" autocomplete="off"
								value="<?php echo set_value('client_name', isset($client_data['client_name']) ? $client_data['client_name'] : ''); ?>"/>
							</div>
						</div>

						<div class="col-md-2 col-xs-2" align="center">
		                    <div class="radio">
		                      <label><input type="radio" name="active" id="active" class="" <?php if($client_data['active']=='1') echo "checked='checked'"; ?> value="1" <?php echo $this->form_validation->set_radio('active', 1); ?> />Active&nbsp;&nbsp;&nbsp;&nbsp;</label>
		                      <label><input type="radio" name="active" id="active" class="" <?php if($client_data['active']=='2') echo "checked='checked'"; ?> value="2" <?php echo $this->form_validation->set_radio('active', 2); ?> />Inactive</label>
		                    </div>
                  		</div>

					</div>
					<!-- /end row divide by 4-->




					<div class="form-group">
						<label for="address">Address <font color="red">*</font></label>
						<input type="text" class="form-control" id="address" name="address"
						value="<?php echo set_value('address', isset($client_data['address']) ? $client_data['address'] : ''); ?>"  autocomplete="off"/>
					</div>

					<!-- /row divide by 4-->
					<div class="row">
						<div class="col-md-3 col-xs-3">
							<div class="form-group">
								<label for="county">County <font color="red">*</font></label>
								<select class="form-control select_group" id="county" name="county">
									<option value=""></option>
									<?php foreach ($county as $k => $v): ?>
										<option value="<?php echo $v['id'] ?>"
										<?php if(set_value('county', isset($client_data['county_id']) ? $client_data['county_id'] : '') == $v['id']) { echo "selected='selected'"; } ?> ><?php echo $v['name'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="col-md-3 col-xs-3">
							<div class="form-group">
								<label for="parish">Parish <font color="red">*</font></label>
								<select class="form-control select_group" id="parish" name="parish">
									<option value=""></option>
									<?php foreach ($parish as $k => $v): ?>
										<option value="<?php echo $v['id'] ?>"
										<?php if(set_value('parish', isset($client_data['parish_id']) ? $client_data['parish_id'] : '') == $v['id']) { echo "selected='selected'"; } ?> ><?php echo $v['name'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="col-md-3 col-xs-3">
						<div class="form-group">
							<label for="city">City</label>
							<select class="form-control select_group" id="city" name="city">
								<option value=""></option>
								<?php foreach ($city as $k => $v): ?>
										<option value="<?php echo $v['id'] ?>"
										<?php if(set_value('city', isset($client_data['city_id']) ? $client_data['city_id'] : '') == $v['id']) { echo "selected='selected'"; } ?> ><?php echo $v['name'] ?></option>
									<?php endforeach ?>
							</select>
					 	</div>
				 	</div>

					<div class="col-md-3 col-xs-3">
					<div class="form-group">
						<label for="district">District</label>
						<input type="text" class="form-control" id="district" name="district" autocomplete="off"
						value="<?php echo set_value('district', isset($client_data['district']) ? $client_data['district'] : ''); ?>"/>
					 </div>
				 </div>

				</div>
					<!-- /end row divide by 4-->


				<!-- /row divide by 4-->
				<div class="row">				 

				 <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<label for="postal_box">Postal Box</label>
						<input type="text" class="form-control" id="postal_box" name="postal_box" autocomplete="off"
						value="<?php echo set_value('postal_box', isset($client_data['postal_box']) ? $client_data['postal_box'] : ''); ?>"/>
				 	</div>
				 </div>

				 <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<label for="postal_code">Postal Code</label>
						<input type="text" class="form-control" id="postal_code" name="postal_code" autocomplete="off"
						value="<?php echo set_value('postal_code', isset($client_data['postal_code']) ? $client_data['postal_code'] : ''); ?>"/>
					 </div>
				 </div>

				 <div class="col-md-3 col-xs-3">
						<div class="form-group">
							<label for="email">Email <font color="red">*</font></label>
							<input type="text" class="form-control" id="email" name="email" autocomplete="off"
						value="<?php echo set_value('email', isset($client_data['email']) ? $client_data['email'] : ''); ?>"/>
						</div>
					</div>
				 <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<label for="website">Website</label>
							<input type="text" class="form-control" id="website" name="website" autocomplete="off"
						    value="<?php echo set_value('website', isset($client_data['website']) ? $client_data['website'] : ''); ?>"/>
						</div>
					</div>
				</div>
					<!-- /end row divide by 4-->


				<!-- /row divide by 3-->
					<div class="row">
						<div class="col-md-4 col-xs-4">
							<div class="form-group">
								 <label for="director_name">Director Name</label>
								<input type="text" class="form-control" id="director_name" name="director_name" autocomplete="off"
							    value="<?php echo set_value('director_name', isset($client_data['director_name']) ? $client_data['director_name'] : ''); ?>"/>
							</div>
						 </div>

						<div class="col-md-4 col-xs-4">
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="text" class="form-control" id="phone" name="phone" autocomplete="off"
							    value="<?php echo set_value('phone', isset($client_data['phone']) ? $client_data['phone'] : ''); ?>"/>
							</div>
						</div>

						<div class="col-md-4 col-xs-4">
							<div class="form-group">
								<label for="mobile">Mobile</label>
								<input type="text" class="form-control" id="mobile" name="mobile" autocomplete="off"
						    	value="<?php echo set_value('mobile', isset($client_data['mobile']) ? $client_data['mobile'] : ''); ?>"/>
							</div>
						</div>
					</div>
					<!-- /end row divide by 3-->


				<div class="form-group">
					<label for="remark">Remark</label>
					<textarea type="text" class="form-control" rows="3" id="remark" name="remark" autocomplete="off"><?php echo set_value('remark', isset($client_data['remark']) ? $client_data['remark'] : ''); ?></textarea>
				</div>

				</div> <!-- /end box -->

				<div class="box-footer">
					<div class="row">
                  		<div class="col-md-6 col-xs-6">

                  			 <?php if(in_array('updateConsultation', $user_permission)): ?>   <!-- you must have the permission to update with the Save button -->   
					              <button type="submit" class="btn btn-primary">Save</button>
					         <?php endif; ?>

							<?php echo '<a href="'.base_url('report_client/REP0C/'.$client_data['id']).'" target="_blank" class="btn btn-success"><i class="fa fa-print"></i></a>'; ?>
							<a href="<?php echo base_url('client/') ?>" class="btn btn-warning">Close</a>
						</div>
					
						<div class="col-md-6 col-xs-6" align="right">
	                    Last update <?php echo $client_data['updated_date']; ?> by <?php echo $client_data['updated_by']; ?>
	                 	</div>		
					</div>
				</div>




			</form>
		</div>
	</div>


<!--Javascript for Client--->


<script type="text/javascript">

	$(document).ready(function() {
		$(".select_group").select2({width: '100%'});
		//$("#remark").wysihtml5();
		$("#mainClientNav").addClass('active');
		$("#manageClientNav").addClass('active');

	});
</script>




<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        C O N S U L T A T I O N                                  -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


    <div id="consultation" class="tab-pane fade <?php echo (($active_tab === 'consultation') ? 'in active' : '') ?>">	

		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="box">
					<div class="box-body">

						<?php if(in_array('createConsultation', $user_permission)): ?>
							<a href="<?php echo base_url('consultation/create') ?>" class="btn btn-primary">Add Consultation</a>
							<br /> <br />
						<?php endif; ?>

						<table id="manageTableConsultation" class="table table-bordered table-striped" style="width:100%">
							<thead>
								<tr>
									<th>Consultation No</th>
									<th>Description</th>
									<th>Standard</th>
									<th>Consultant</th>
									<th>Sector</th>
									<th>Phase</th>
									<th>Status</th>
									<th>Date creation</th>
									<?php if(in_array('updateConsultation', $user_permission) || in_array('deleteConsultation', $user_permission)): ?>
									<th>Action</th>
									<?php endif; ?>
								</tr>
							</thead>
						</table>

					</div>
				 </div>
			</div>
		</div>
	</div>

<!-- Delete Consultation -->

<?php if(in_array('deleteConsultation', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeConsultationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Consultation</h4>
      </div>
      <form role="form" action="<?php echo base_url('consultation/remove') ?>" method="post" id="removeFormConsultation">
        <div class="modal-body">
          <p>Do you really want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php endif; ?>



<!------------------------------------->
<!-- Javascript part of Consultation     --->
<!------------------------------------->

<script type="text/javascript">
var manageTableConsultation;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

	$("#consultationClientNav").addClass('active');


	// initialize the datatable
	manageTableConsultation = $('#manageTableConsultation').DataTable({
		'ajax': base_url+'consultation/fetchConsultationClient/'+<?php echo $client_data['id']; ?>,
		'order': [[0, 'asc']]
	});

});


function removeConsultation(id)
{
  if(id) {
    $("#removeFormConsultation").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { consultation_id:id },
        dataType: 'json',
        success:function(response) {

          manageTableConsultation.ajax.reload(null, false);

          if(response.success === true) {
            // hide the modal
            $("#removeConsultationModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      });

      return false;
    });
  }
}
</script>





<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                       I N Q U I R Y                                           -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->

	<div id="inquiry" class="tab-pane fade <?php echo (($active_tab === 'inquiry') ? 'in active' : '') ?>">	
		<div class="box">
			<div class="box-body">
				<div class="row">  <!-- /row divide by 2-->
					 <div class="col-md-12 col-xs-12">

					<?php if(in_array('createInquiry', $user_permission)): ?>
			          <button class="btn btn-primary" data-toggle="modal" data-target="#createModalInquiry">
			          Add Inquiry</button>
			          <br /> <br />
			        <?php endif; ?>

					<table id="manageTableInquiry" class="table table-bordered table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Inquiry Type</th>
								<th>Support Type</th>
								<th>Request</th>
								<th>Feedback</th>
								<th>Answered by</th>
								<th>Date</th>
								<?php if(in_array('updateInquiry', $user_permission) || in_array('deleteInquiry', $user_permission)): ?>
				                <th>Action</th>
				                <?php endif; ?>
							</tr>
						</thead>
					</table>
					</div>
				 </div>
			</div>
		</div>
	</div>


<!-- Add Inquiry ------------------------------------------------------------------------------------->

<?php if(in_array('createInquiry', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="createModalInquiry">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Inquiry</h4>
      </div>

      <form role="form" action="<?php echo base_url('inquiry/create') ?>" method="post" id="createFormInquiry">

        <div class="modal-body">

          <div class="form-group">
            <label>Inquiry Type<font color="red"> *</font></label>
              <select name="inquiry_type" id="inquiry_type" class="form-control select2" style="width: 100%;">
              </select>
          </div>

          <div class="form-group">
            <label>Support Type<font color="red"> *</font></label>
              <select name="support_type" id="support_type" class="form-control select2" style="width: 100%;">
              </select>
          </div>

          <div class="form-group">
            <label for="request">Request</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="request" name="request" autocomplete="off"></textarea>
          </div>

          <div class="form-group">
            <label for="feedback">Feedback</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="feedback" name="feedback" autocomplete="off"></textarea>
          </div>

		  <div class="row">
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="answered_by">Answered by</label>
                <input type="text" class="form-control" id="answered_by" name="answered_by" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="inquiry_date">Date</label>
                <input type="date" class="form-control" id="inquiry_date" name="inquiry_date" autocomplete="off">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>




<!-- Edit Inquiry ------------------------------------------------------------------------------------->

<?php if(in_array('updateInquiry', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="editModalInquiry">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Inquiry</h4>
      </div>

      <form role="form" action="<?php echo base_url('inquiry/update') ?>" method="post" id="editFormInquiry">

        <div class="modal-body">
          <div id="messages"></div>

		  <div class="form-group">
            <label>Inquiry Type<font color="red"> *</font></label>
              <select name="edit_inquiry_type" id="inquiry_type" class="form-control select2" style="width: 100%;">
              </select>
          </div>

          <div class="form-group">
            <label>Support Type<font color="red"> *</font></label>
              <select name="edit_support_type" id="support_type" class="form-control select2" style="width: 100%;">
              </select>
          </div>

		  <div class="form-group">
            <label for="edit_request">Request</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="edit_request" name="edit_request" autocomplete="off"></textarea>
          </div>

          <div class="form-group">
            <label for="edit_feedback">Feedback</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="edit_feedback" name="edit_feedback" autocomplete="off"></textarea>
          </div>
		  <div class="row">
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="edit_answered_by">Answered by</label>
                <input type="text" class="form-control" id="edit_answered_by" name="edit_answered_by" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="edit_inquiry_date">Date</label>
                <input type="date" class="form-control" id="edit_inquiry_date" name="edit_inquiry_date" autocomplete="off">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>


<!-- Delete Inquiry --------------------------------------------------------------------------------->

<?php if(in_array('deleteInquiry', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeModalInquiry">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Inquiry</h4>
      </div>

      <form role="form" action="<?php echo base_url('inquiry/remove') ?>" method="post" id="removeFormInquiry">
        <div class="modal-body">
          <p>Do you really want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>


<!------------------------------------->
<!-- Javascript part of Inquiry    --->
<!------------------------------------->

<script type="text/javascript">
var manageTableInquiry;
var base_url = "<?php echo base_url(); ?>";

//---> Prepare the view list

$(document).ready(function() {

	//---> creation of the drop-down list inquiry type
    $inquiry_type = $('[id="inquiry_type"]');
    $.ajax({
        url: base_url+'inquiry_type/fetchActiveInquiryType',
        dataType: "JSON",
        success: function (data) {
            $inquiry_type.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $inquiry_type.append('<option value="' + val.id + '">' + val.name + '</option>');
            });

        },
        error: function () {
        //if there is an error append a 'none available' option
        $inquiry_type.html('<option id="-1">none available</option>');
        }
    });

    //---> creation of the drop-down list support type
    $support_type = $('[id="support_type"]');
    $.ajax({
        url: base_url+'support_type/fetchActiveSupportType',
        dataType: "JSON",
        success: function (data) {
            $support_type.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $support_type.append('<option value="' + val.id + '">' + val.name + '</option>');
            });

        },
        error: function () {
        //if there is an error append a 'none available' option
        $support_type.html('<option id="-1">none available</option>');
        }
    });



	$("#inquiryClientNav").addClass('active');

	// initialize the datatable
	manageTableInquiry = $('#manageTableInquiry').DataTable({
		'ajax': base_url+'inquiry/fetchInquiryClient/'+<?php echo $client_data['id']; ?>,
		'order': [[0, 'desc']]
	});

 //---> Submit the create form

  $("#createFormInquiry").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTableInquiry.ajax.reload(null, false);

        if(response.success === true) {

          // hide the modal
          $("#createModalInquiry").modal('hide');

          // reset the form
          $("#createFormInquiry")[0].reset();
          $("#createFormInquiry .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');

              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    });

    return false;
  });

});

//---> Edit function

function editInquiry(id)

{
  $.ajax({
    url: base_url + 'inquiry/fetchInquiryDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
	     $('[name="edit_inquiry_type"]').val(response.inquiry_type_id);
	     $('[name="edit_support_type"]').val(response.support_type_id);
	     $("#edit_request").val(response.request);
	     $("#edit_feedback").val(response.feedback);
	     $("#edit_answered_by").val(response.answered_by);
		 $("#edit_inquiry_date").val(response.inquiry_date);




	     // submit the update form
	     $("#editFormInquiry").unbind('submit').bind('submit', function() {
	        var form = $(this);

	    // remove the text-danger
	    $(".text-danger").remove();

	    $.ajax({
	      url: form.attr('action') + '/' + id,
	      type: form.attr('method'),
	      data: form.serialize(), // converting the form data into array and sending it to server
	      dataType: 'json',
	      success:function(response) {

	        manageTableInquiry.ajax.reload(null, false);

	        if(response.success === true) {

	          // hide the modal
	          $("#editModalInquiry").modal('hide');
	          // reset the form
	          $("#editFormInquiry .form-group").removeClass('has-error').removeClass('has-success');

	        } else {

	          if(response.messages instanceof Object) {
	            $.each(response.messages, function(index, value) {
	              var id = $("#"+index);

	              id.closest('.form-group')
	              .removeClass('has-error')
	              .removeClass('has-success')
	              .addClass(value.length > 0 ? 'has-error' : 'has-success');

	              id.after(value);

	            });
	          } else {
	            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
	              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
	              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
	            '</div>');
	          }
	        }
	      }
	    });

	    return false;
	  });

    }
  });
}

//---> Delete functions

function removeInquiry(id)
{
  if(id) {
    $("#removeFormInquiry").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { inquiry_id:id },
        dataType: 'json',
        success:function(response) {

          manageTableInquiry.ajax.reload(null, false);

          if(response.success === true) {
           // hide the modal
            $("#removeModalInquiry").modal('hide');
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }

        }
      });

      return false;
    });
  }
}

</script>




<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        D O C U M E N T                                         -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


  <div id="document" class="tab-pane fade <?php echo (($active_tab === 'document') ? 'in active' : '') ?>">	

			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12 col-xs-12">


							<?php echo form_open_multipart('client/uploadDocument') ?>
							<?php echo "<table width='100%'>" ?>
							<?php echo "<tr>" ?>
							<?php if(in_array('createDocument', $user_permission)): ?>
								<?php echo "<td width='10%' align=left><input type='file' required='required' name='client_document' id='client_document' size='60'  /></td>" ?>
								<?php echo "<td><input type='submit' name='submit' class='btn btn-primary' value='Add Document' /></td>" ?>
							<?php endif; ?>	
							<?php echo "</tr>" ?>
							<?php echo "</table>" ?>
							<?php echo "</form>"?>

							<br>

							<div class="col-md-12 col-xs-12">
								<table id="manageTableDocument" class="table table-bordered table-striped" style="width:100%">
									<thead>
										<tr>
											<th>Type</th>
											<th>Document</th>
											<th>Size</th>
											<th>Consultation</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
						</div>
					</div>
				</div>

				<div class="box-footer">

						<a href="<?php echo base_url('client/') ?>" class="btn btn-warning">Close</a>
				</div>

			</form>
		</div>
	</div>
	</div>



<!--  End of the form  -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>


<!-- Delete Document -->

<?php if(in_array('deleteDocument', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeDocumentModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Document</h4>
      </div>
      <form role="form" action="<?php echo base_url('client/removeDocument') ?>" method="post" id="removeFormDocument">
        <div class="modal-body">
          <p>Do you really want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php endif; ?>


<!------------------------------------->
<!-- Javascript part of Document    --->
<!------------------------------------->

<script type="text/javascript">
var manageTableDocument;
var base_url = '<?php echo base_url(); ?>';
var document_client_id = <?php echo $client_data['id']; ?>;
var document_type_id = 'all';  //for all type of documents

	$("#DocumentClientNav").addClass('active');

	// initialize the datatable
	manageTableDocument = $('#manageTableDocument').DataTable({
		'ajax': {
			    url: base_url + 'client/fetchClientDocument/',
			    type: 'POST',
			    dataType: 'json',
			    data: {document_client_id: document_client_id, document_type_id: document_type_id},
			    },
		
		'order': [[0, "asc"]]
	});


function removeDocument(id)
{
  if(id) {
    $("#removeFormDocument").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { document_id:id },
        dataType: 'json',
        success:function(response) {

          manageTableDocument.ajax.reload(null, false);

          if(response.success === true) {
            // hide the modal
            $("#removeDocumentModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      });

      return false;
    });
  }
}
</script>