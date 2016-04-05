<?php

if(!isset($title) or $title == '' or is_null($title)) $title = 'Assesment opdracht DBK';
?>
		
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Assesment">
		<meta name="author" content="Elwin">

		<title><? echo $title; ?></title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		<link href="css/custom.css" rel="stylesheet">
		
		<!-- jquery 1.12.2 minified -->
		<script src="js/jquery.min.js"></script>
	</head>
	
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-4">
							<div class="row">
								<label for="direct">Direct</label>
								<input id="direct" name="direct" value="<? echo $values['direct']; ?>" class="percentage"/>
							</div>
							<div class="row">
								<label for="google">Google</label>
								<input id="google" name="google" value="<? echo $values['google']; ?>" class="percentage"/>
							</div>
							<div class="row">
								<label for="adwords">Adwords</label>
								<input id="adwords" name="adwords" value="<? echo $values['adwords']; ?>" class="percentage"/>
							</div>
							<div class="row">
								<label for="vw_betaald">Verwijzende sites, betaald</label>
								<input id="vw_betaald" name="vw_betaald" value="<? echo $values['vw_betaald']; ?>" class="percentage"/>
							</div>
							<div class="row">
								<label for="vw_onbetaald">onbetaald</label>
								<input id="vw_onbetaald" name="vw_onbetaald" value="<? echo $values['vw_onbetaald']; ?>" class="percentage"/>
							</div>
							<div class="row">
								<label for="overig">Overig</label>
								<input id="overig" name="overig" value="<? echo $values['overig']; ?>" class="percentage"/>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<label for="conversie">Conversie percentage</label>
								<input id="conversie" name="conversie" value="<? echo $values['conversie']; ?>"/>
							</div>
							<div class="row"><p><span class="bezoekers"><? echo $values['bezoekers']; ?></span> bezoekers.</p></div>
							<div class="row">
								<p>
									Voor adwords zijn <span class="adwords_percentage"><? echo $values['adwords']; ?></span>&percnt; van <span class="bezoekers"><? echo $values['bezoekers']; ?></span> bezoekers nodig is <span class="adwords_bezoekers_nodig"><? echo $values['adwords_bezoekers_nodig']; ?></span>.<br/>
									Met de ingevoerde zoektermen zijn er <span class="totaal_zoekvolume"><? echo $values['totaal_zoekvolume']; ?></span> bezoekers mogelijk.<br/>
									Dit is dus <span class="adwords_mogelijk"><? echo (($values['totaal_zoekvolume'] >= $values['adwords_bezoekers_nodig']) ? 'WEL' : 'NIET'); ?></span> mogelijk!
								</p>
							</div>							
							<div class="row">
								<p>
									Gemiddelde CPC is &euro;<span class="cpc_prijs"><? echo $values['cpc_prijs']; ?></span> / <span class="bezoekers_kopen"><? echo $values['bezoekers_kopen']; ?></span> bezoekers.<br/>
									&euro;<span class="cpc_budget"><? echo $values['cpc_budget']; ?></span> budget per bezoek.<br/>
									De ingevoerde zoektermen hebben een gemiddeld CPC van &euro;<span class="cpc_euros"><? echo $values['cpc_euros']; ?></span>.
									Uw budget is dus <span class="budget_toereikend"><? echo (($values['cpc_euros'] <= $values['cpc_budget']) ? 'WEL' : 'NIET'); ?></span> toereikend! 
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="row">
								<p>
									Betaald verkeer is <span class="adwords_percentage"><? echo $values['adwords']; ?></span>&percnt; Adwords + <span class="vw_betaald"><? echo $values['vw_betaald']; ?></span>&percnt; links<br/>
									Samen <span class="percentage_samen"><? echo $values['percentage_samen']; ?></span>&percnt;
								</p>
							</div>
							<div class="row">
								<p>
									<span class="percentage_samen"><? echo $values['percentage_samen']; ?></span>&percnt; van <span class="bezoekers"><? echo $values['bezoekers']; ?></span> bezoekers is
									<span class="bezoekers_kopen"><? echo $values['bezoekers_kopen']; ?></span> bezoekers kopen
								</p>
							</div>
						</div>	
					</div>	
				</div>
				<div class="col-sm-4">
					<div class="row">
						<label for="benodigde_bestellingen">Benodigde bestellingen (conversie)</label>
						<input id="benodigde_bestellingen" name="benodigde_bestellingen" value="<? echo $values['benodigde_bestellingen']; ?>"/>
					</div>
					<div class="row">
						<label for="bestel_waarde">Gemiddelde bestelwaarde</label>
						<input id="bestel_waarde" name="bestel_waarde" value="<? echo $values['bestel_waarde']; ?>"/>
					</div>
					<div class="row">
						<label for="omzet">Doelstelling/Omzet per maand</label>
						<input id="omzet" name="omzet" value="<? echo $values['omzet']; ?>"/>
					</div>
					<div class="row">
						<label for="marge">Marge</label>
						<select id="marge" name="marge">
							<option value="15" <? echo (($values['marge'] == 15) ? 'selected="selected"' : ''); ?>>&gt; 15&percnt;</option>
							<option value="0" <? echo (($values['marge'] == 0) ? 'selected="selected"' : ''); ?>>&lt; 15&percnt;</option>
						</select>
					</div>
					<div class="row">
						<label for="marketing_budget_percentage">Budget marketing</label>
						<input id="marketing_budget_percentage" name="marketing_budget_percentage" value="<? echo $values['marketing_budget_percentage']; ?>"/>&nbsp;->&nbsp;<input id="marketing_budget_bedrag" name="marketing_budget_bedrag" value="<? echo $values['marketing_budget_bedrag']; ?>"/>&euro;
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-4">
							<p>
								Zoekterm
							</p>
						</div>
						<div class="col-sm-2">
							<p>
								CPC-waarde
							</p>
						</div>
						<div class="col-sm-2">
							<p>
								Zoekvolume
							</p>
						</div>
					</div>
<?php
	foreach($values as $k => $v){
		if(is_array($v) and $v['woord'] != ''){
?>
					<div class="row">
						<div class="col-sm-4">
							<p>
								<? echo $v['woord']; ?>
							</p>
						</div>
						<div class="col-sm-2">
							<p>
								<? echo $v['cpc']; ?>
							</p>
						</div>
						<div class="col-sm-2">
							<p>
								<? echo $v['volume']; ?>
							</p>
						</div>
					</div>
<?php			
		}
	}
?>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){			
				$(":input").change(function(){
					// voor alle input velden, pak de waarden, stop in array om door te sturen.
					var map = {};
					$(":input").each(function() {
						map[$(this).attr("name")] = $(this).val();
					});
					
					
					
					$.ajax({
						url: "/?action=update_resultaat",
						data: map,
						method: 'POST'
					}).done(function(result) {
						var obj = jQuery.parseJSON(result);
						if(obj.status_ok == true){
							$("#omzet").val(obj.omzet);
							$("#marketing_budget_bedrag").val(obj.marketing_budget_bedrag);
							$("#marge").val(obj.marge);
							$("#marketing_budget_percentage").val(obj.marketing_budget_percentage);
							$("#bestel_waarde").val(obj.bestel_waarde);
							$("#conversie").val(obj.conversie);
							$("#direct").val(obj.direct);
							$("#google").val(obj.google);
							$("#adwords").val(obj.adwords);
							$("#vw_betaald").val(obj.vw_betaald);
							$("#vw_onbetaald").val(obj.vw_onbetaald);
							$("#overig").val(obj.overig);
							$(".percentage_samen").text(obj.percentage_samen);
							$(".adwords_percentage").text(obj.adwords_percentage);
							$(".bezoekers").text(obj.bezoekers);
							$(".totaal_zoekvolume").text(obj.totaal_zoekvolume);
							$(".adwords_bezoekers_nodig").text(obj.adwords_bezoekers_nodig);
							$(".cpc_euros").text(obj.cpc_euros);
							$(".cpc_budget").text(obj.cpc_budget);
							$(".cpc_prijs").text(obj.cpc_prijs);							
							if(obj.totaal_zoekvolume >= obj.adwords_bezoekers_nodig){
								$(".adwords_mogelijk").text("WEL");
							} else {
								$(".adwords_mogelijk").text("NIET");
							}
							if(obj.cpc_mogelijk){
								$(".budget_toereikend").text("WEL");
							} else {
								$(".budget_toereikend").text("NIET");
							}
						} else {
							alert(obj.msg);
						}
					});
				});
				
				$("#marge").change(function(){
					console.log($(this).val());
					if($(this).val() == 15){
						$("#marketing_budget_percentage").val("7.5").change();
					} else {
						$("#marketing_budget_percentage").val("2.5").change();
					}
				});
				
			});
		</script>
	</body>
</html>	