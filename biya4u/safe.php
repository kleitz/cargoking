

 <tr>
              <td>Type of Shipment</td>
              <td>
              <?php $ty_query=mysqli_query($conn, "select * from  ty_ship order by id desc"); ?>
              
              
              
              <select name="tyship" style="width:255px;">
                <option value="">--Select--</option>
                
                <?php
				while($ty_row=mysqli_fetch_assoc($ty_query))
				{
					?>
					
					<option value="<?=$ty_row['id']?>"><?=$ty_row['category']?></option>
					
					<?php
					
				}
				?>
                
                
                
                
              </select>
              <span class="Alert">
              <?=$tyship1?>
              </span></td>
              <td class="Alert">&nbsp;</td>
              
            </tr>












<tr>
              <td>Quantity</td>
              <td><input type="text" name="qun" id='qun' style="width:255px;" value=""/></td>
              <td class="Alert">&nbsp;</td>
            </tr>
           
           <tr>
              <td>Price</td>
              <td><input type="text" name="price" id='price' style="width:255px;" value=""/></td>
              <td class="Alert">&nbsp;</td>
            </tr>
            
            <tr>
              <td>Total Amount</td>
              <td><input type="text" name="tot" id='tot' style="width:255px;" value=""/></td>
              <td class="Alert">&nbsp;</td>
            </tr>