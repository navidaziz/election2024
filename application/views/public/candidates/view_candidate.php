<!-- PAGE HEADER-->
<div class="breadcrumb-box">
  <div class="container">
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url("Home"); ?>">Home</a>
					<span class="divider">/</span>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url("candidates/view/"); ?>">Candidates</a>
				<span class="divider">/</span>
			</li><li ><?php echo $title; ?> </li>
				</ul>
			</div>
		</div>
		<!-- .breadcrumb-box --><section id="main">
			  <header class="page-header">
				<div class="container">
				  <h1 class="title"><?php echo $title; ?></h1>
				</div>
			  </header>
			  <div class="container">
			  <div class="row">
			  <?php $this->load->view(PUBLIC_DIR."components/nav"); ?><div class="content span9 pull-right">
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($candidates as $candidate): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('name'); ?></th>
                <td>
                    <?php echo $candidate->name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('political_party'); ?></th>
                <td>
                    <?php echo $candidate->political_party; ?>
                </td>
            </tr>
            <tr>
                <th>Symbol</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$candidate->symbol));
                ?>
                </td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$candidate->image));
                ?>
                </td>
            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			</div>
		</div>
	 </div>
  <!-- .container --> 
</section>
<!-- #main -->
