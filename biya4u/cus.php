<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript">

$(".muc").click(function(){
	
	 $("new1").html("<li><img src='images/loading7.gif' border='0'></li>");
	
	  
    txt=$("#rcustomer").val();
	
    $.get("ins1.php",{suggest:txt},function(result){
      $("#new1").html(result);
    });
  });
</script>

<?php include 'dbconnect.php';


?><?php 

$suggest=$_POST['suggest'];


 $cus_query=mysqli_query($conn, "select * from customer where name like '%$suggest%' || cusid like '%$suggest%' || address like  '%$suggest%' order by id desc") or die(mysqli_error()); 
		  
		  ?>
              
            
             <?php
				while($cus_row=mysqli_fetch_assoc($cus_query))
				{
					?>
					
					
					 <li style="border-bottom:#D2D2D2 1px dotted; cursor:pointer;"><a onclick="lam('<?=$cus_row['cusid']?>');" style="color:#fff;" class="muc"><?php echo stripslashes($cus_row['name']);?>-<?=$cus_row['cusid']?>-<?=$cus_row['city']?></a></li>
					<?php
					
				}
				?>