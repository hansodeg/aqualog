
	<!-- layoutfil for loggeskjema tilhørende de respektive renseanlegg 
    Barneanlegget, FlowRider, Bøverstranda, Nedre Øvre, Nedre Nedre og Øvre-->
    
    <div class="logger">
 <form class="prove_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="prove_form">
 <h2>Ny Vannprøve</h2>  										
			 <input type="number" name="klor" step="0.01" class="form-control" placeholder="Panel klor" required>
			 <input type="number" name="ph" step="0.01" class="form-control" placeholder="Panel pH" required>                                                                                     
			 <input type="number" name="dpd1" step="0.01" class="form-control" placeholder="Dpd1" required>                                                                                   
			 <input type="number" name="dpd3" step="0.01" class="form-control" placeholder="Dpd3" required>                                                                               			
			 <input type="number" name="phenol" step="0.01" class="form-control" placeholder="Phenol" required>                                                                                                                                                                             		
			 <input type="text" name="signatur"  class="form-control" placeholder="Signatur" required>
	 <button type="submit" name="prove">Lagre</button>
	 <button onClick="location.href='vannprover.php'" type="button" style="margin-top: 10px;">Legg til Labprøve</button>      
	 </form>                                         			
	 </div>
