<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
     select option:hover {
        cursor: pointer;
    }
</style>
<!-- Editing form modal -->
<div id="editTreatment" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 style="font-weight: bold; color: white; height: 10px">Reschedule</h5>
            </div> --}}
            <form action="/reschedule" method="POST" id="rescheduleModal">
                @csrf
                <div class="modal-body">
                    <div class="row"> 
                <div class=" col-md-5">
                    <label for="cancer" style="text-transform: capitalize;font-size:16px;font-weight:bolder">Legend:</label>
                    <div class="row col-12">
                        <div class="form-group">
                          <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Condition</label><br>
                          <label for="cancer" style="text-transform: capitalize;font-size:10px">D- Decayed (caries indicated for filling)</label><br>
                          <label for="heart" style="text-transform: capitalize;font-size:10px">M- Missing</label><br>
                          <label for="hypertension" style="text-transform: capitalize;font-size:10px">F- Filled</label><br>
                          <label for="thyroid" style="text-transform: capitalize;font-size:10px">I- Caries indicated for Extraction</label><br>
                          <label for="tuberculosis" style="text-transform: capitalize;font-size:10px">RF- Root Fragment</label><br>
                          <label for="thyroid" style="text-transform: capitalize;font-size:10px">MO- Missing due to Other Causes</label><br>
                          <label for="tuberculosis" style="text-transform: capitalize;font-size:10px">Im- Impacted Tooth</label><br>
                        </div>
                        <div class="form-group mx-auto">
                          <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Restoration & Prosthetics</label><br>
                          <label for="diabetes" style="text-transform: capitalize;font-size:10px">J- Jacket Crown</label><br>
                          <label for="mental" style="text-transform: capitalize;font-size:10px">A- Amalgam Filling</label><br>
                          <label for="asthma" style="text-transform: capitalize;font-size:10px">AB- Abutment</label><br>
                          <label for="convulsion" style="text-transform: capitalize;font-size:10px">P- Pontic</label><br>
                          <label for="bleeding" style="text-transform: capitalize;font-size:10px">In- Inlay</label><br>
                          <label for="bleeding" style="text-transform: capitalize;font-size:10px">Fx- Fixed Cure Composite</label><br>
                          <label for="bleeding" style="text-transform: capitalize;font-size:10px">S- Sealant</label><br>
                          <label for="bleeding" style="text-transform: capitalize;font-size:10px">Rm- Removable Denture</label><br>
                        </div>
                      </div>
                      
                      <div class="row col-12">
                        <div class="form-group">
                          <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Surgery</label><br>
                          <label for="vehiceyele1" style="text-transform: capitalize;font-size:10px">X- Extraction due to Causes</label><br>
                          <label for="skin" style="text-transform: capitalize;font-size:10px">XO- Extraction due to Other Causes</label><br>
                        </div>
                        <div class="form-group mx-auto">
                          <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Others</label><br>
                          <label for="gastrointestinal" style="text-transform: capitalize;font-size:10px">✓- Present Teeth</label><br>
                          <label for="vehicle2" style="text-transform: capitalize;font-size:10px">Cm- Congenitally Missing</label><br>
                          <label for="vehicle2" style="text-transform: capitalize;font-size:10px">Sp- Supernumerary</label><br>
                        </div>
                      </div>

                      <div class="row col-12">
                        <div class="form-group ">
                            <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Periodontal Screening:</label><br>
                            <input type="checkbox" id="Gingivits " name="periodontal[]" value="Gingivits" disabled >
                            <label for="cancer" style="text-transform: capitalize;font-size:10px">Gingivits</label><br>
                            <input type="checkbox" id="vehicle1" name="periodontal[]" value="Early Periodontitis" disabled>
                            <label for="heart" style="text-transform: capitalize;font-size:10px">Early Periodontitis</label><br>
                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Moderate Periodontitis" disabled>
                            <label for="hypertension" style="text-transform: capitalize;font-size:10px">Moderate Periodontitis</label><br>
                            <input type="checkbox" id="vehicle1" name="periodontal[]" value="Advance Periodontitis" disabled>
                            <label for="thyroid" style="text-transform: capitalize;font-size:10px">Advance Periodontitis</label><br>
                          </div>
                          <div class=" mx-auto">
                            <div class="form-group">
                              <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Occlusion:</label><br>
                              <input type="checkbox" id="vehicle1" name="occlusion[]" value="Class Molar" disabled>
                              <label for="diabetes" style="text-transform: capitalize;font-size:10px">Class(Molar)</label><br>
                              <input type="checkbox" id="vehicle1" name="occlusion[]" value="Overjet" disabled>
                              <label for="mental" style="text-transform: capitalize;font-size:10px">Overjet</label><br>
                              <input type="checkbox" id="vehicle1" name="occlusion[]" value="Overbite" disabled>
                              <label for="asthma" style="text-transform: capitalize;font-size:10px">Overbite</label><br>     
                              <input type="checkbox" id="vehicle1" name="occlusion[]" value="Midline Deviation" disabled>                  
                              <label for="convulsion" style="text-transform: capitalize;font-size:10px">Midline Deviation</label><br>  
                              <input type="checkbox" id="vehicle1" name="occlusion[]" value="Crossbite" disabled> 
                              <label for="bleeding" style="text-transform: capitalize;font-size:10px">Crossbite</label><br>
                            </div>
                          </div>
                      </div>
                      

                      <div class="row col-12">
                        <div class="form-group">
                            <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">Appliances:</label><br>
                            <input type="checkbox" id="vehicle1" name="appliances[]" value="Orthodontic" disabled>
                            <label for="vehiceyele1" style="text-transform: capitalize;font-size:10px">Orthodontic</label><br>
                            <input type="checkbox" id="vehicle1" name="appliances[]" value="Stayplate" disabled>
                            <label for="skin" style="text-transform: capitalize;font-size:10px">Stayplate</label><br>
                            <input type="checkbox" id="others" name="appliances[]" value="Others" disabled>
                            <label for="others" style="text-transform: capitalize; font-size: 10px">Others</label><br>
                            <input class="form-control othersApp" type="text" id="othersApp" name="othersApp" value="" disabled>                  
                          </div>
                          <div class="mx-auto">
                              <div class="form-group">
                              <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bold">TMD:</label><br>
                              <input type="checkbox" id="vehicle1" name="tmd[]" value="Clenching" disabled>
                                <label for="diabetes" style="text-transform: capitalize;font-size:10px">Clenching</label><br>
                                <input type="checkbox" id="vehicle1" name="tmd[]" value="Clicking" disabled>
                                <label for="mental" style="text-transform: capitalize;font-size:10px">Clicking</label><br>
                                <input type="checkbox" id="vehicle1" name="tmd[]" value="Trismus" disabled>
                                <label for="asthma" style="text-transform: capitalize;font-size:13px">Trismus</label><br>
                                <input type="checkbox" id="vehicle1" name="tmd[]" value="Muscle Spasm" disabled> 
                                <label for="convulsion" style="text-transform: capitalize;font-size:13px">Muscle Spasm</label>
                              </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-7">
                    <h6 style="text-align:center;font-weight:bold">INTRAORAL EXAMINATION</h6>
                    <table class="" style="margin:auto;text-align:center;font-size:12px">
                        <thead class="head">
                            <tr>
                              <td colspan="3" style="border:none">Status</td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="55" value="<?php echo isset($details[0]) ? $details[0] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="54" value="<?php echo isset($details[1]) ? $details[1] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="53" value="<?php echo isset($details[2]) ? $details[2] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="52" value="<?php echo isset($details[3]) ? $details[3] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="51" value="<?php echo isset($details[4]) ? $details[4] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="61" value="<?php echo isset($details[5]) ? $details[5] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="62" value="<?php echo isset($details[6]) ? $details[6] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="63" value="<?php echo isset($details[7]) ? $details[7] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="64" value="<?php echo isset($details[8]) ? $details[8] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  name="dental_issues[]" toothId="65" value="<?php echo isset($details[9]) ? $details[9] : ''; ?>" readonly></td>
                              <td colspan="3" style="border:none"></td>
                           </tr>
                            <tr>
                                <td colspan="3"  style="border:none;font-weight:bold;"> Right</td>
                                <td class="border"  style="font-weight:700;" >55</td>
                                <td class="border" style="font-weight:700;">54</td>
                                <td class="border" style="font-weight:700;">53</td>
                                <td class="border" style="font-weight:700;">52</td>
                                <td class="border" style="font-weight:700;">51</td>
                                <td class="border" style="font-weight:700;">61</td>
                                <td class="border" style="font-weight:700;">62</td>
                                <td class="border" style="font-weight:700;">63</td>
                                <td class="border" style="font-weight:700;">64</td>
                                <td class="border" style="font-weight:700;">65</td>
                                <td colspan="3" style="border:none;font-weight:bold;"> Left</td>
                            </tr>
                            <tr>
                              <td colspan="3" style="border:none">Temporary Teeth</td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td colspan="3" style="border:none"></td>
                          </tr>
                            <tr>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="18U" name="dental_issues[]" value="<?php echo isset($details[10]) ? $details[10] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="17U" name="dental_issues[]" value="<?php echo isset($details[11]) ? $details[11] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="16U" name="dental_issues[]" value="<?php echo isset($details[12]) ? $details[12] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="15U" name="dental_issues[]" value="<?php echo isset($details[13]) ? $details[13] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="14U" name="dental_issues[]" value="<?php echo isset($details[14]) ? $details[14] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="13U" name="dental_issues[]" value="<?php echo isset($details[15]) ? $details[15] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="12U" name="dental_issues[]" value="<?php echo isset($details[16]) ? $details[16] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="11U" name="dental_issues[]" value="<?php echo isset($details[17]) ? $details[17] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="21U" name="dental_issues[]" value="<?php echo isset($details[18]) ? $details[18] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="22U" name="dental_issues[]" value="<?php echo isset($details[19]) ? $details[19] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="23U" name="dental_issues[]" value="<?php echo isset($details[20]) ? $details[20] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="24U" name="dental_issues[]" value="<?php echo isset($details[21]) ? $details[21] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="25U" name="dental_issues[]" value="<?php echo isset($details[22]) ? $details[22] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="26U" name="dental_issues[]" value="<?php echo isset($details[23]) ? $details[23] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="27U" name="dental_issues[]" value="<?php echo isset($details[24]) ? $details[24] : ''; ?>" readonly></td>
                              <td class="border"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="28U" name="dental_issues[]" value="<?php echo isset($details[25]) ? $details[25] : ''; ?>" readonly></td> 
                            </tr>
                            <tr>
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="18L" name="dental_issues[]" value="<?php echo isset($details[26]) ? $details[26] : ''; ?>" readonly></td>                              
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="17L" name="dental_issues[]" value="<?php echo isset($details[27]) ? $details[27] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="16L" name="dental_issues[]" value="<?php echo isset($details[28]) ? $details[28] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="15L" name="dental_issues[]" value="<?php echo isset($details[29]) ? $details[29] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="14L" name="dental_issues[]" value="<?php echo isset($details[30]) ? $details[30] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="13L" name="dental_issues[]" value="<?php echo isset($details[31]) ? $details[31] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="12L" name="dental_issues[]" value="<?php echo isset($details[32]) ? $details[32] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="11L" name="dental_issues[]" value="<?php echo isset($details[33]) ? $details[33] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="22L" name="dental_issues[]" value="<?php echo isset($details[34]) ? $details[34] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="23L" name="dental_issues[]" value="<?php echo isset($details[35]) ? $details[35] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="24L" name="dental_issues[]" value="<?php echo isset($details[36]) ? $details[36] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="25L" name="dental_issues[]" value="<?php echo isset($details[37]) ? $details[37] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="26L" name="dental_issues[]" value="<?php echo isset($details[38]) ? $details[38] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="27L" name="dental_issues[]" value="<?php echo isset($details[39]) ? $details[39] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="28L" name="dental_issues[]" value="<?php echo isset($details[40]) ? $details[40] : ''; ?>" readonly></td>
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="48L" name="dental_issues[]" value="<?php echo isset($details[41]) ? $details[41] : ''; ?>" readonly></td> 
                              </tr>
                            <tr>
                                <td class="border" style="font-weight:700;">18</td>
                                <td class="border" style="font-weight:700;">17</td>
                                <td class="border" style="font-weight:700;">16</td>
                                <td class="border" style="font-weight:700;">15</td>
                                <td class="border" style="font-weight:700;">14</td>
                                <td class="border" style="font-weight:700;">13 </td>
                                <td class="border" style="font-weight:700;">12</td>
                                <td class="border" style="font-weight:700;">11</td>
                                <td class="border" style="font-weight:700;">21</td>
                                <td class="border" style="font-weight:700;">22</td>
                                <td class="border" style="font-weight:700;">23 </td>
                                <td class="border" style="font-weight:700;">24</td>
                                <td class="border" style="font-weight:700;">25</td>
                                <td class="border" style="font-weight:700;">26</td>
                                <td class="border" style="font-weight:700;">27 </td>
                                <td class="border" style="font-weight:700;">28</td>
                            </tr>
                            <tr>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            </tr>
                            <tr>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                              <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                            </tr>
                            <tr>
                                <td class="border" style="font-weight:700;">48 </td>
                                <td class="border" style="font-weight:700;">47 </td>
                                <td class="border" style="font-weight:700;">46</td>
                                <td class="border" style="font-weight:700;">45</td>
                                <td class="border" style="font-weight:700;">44</td>
                                <td class="border" style="font-weight:700;">43</td>
                                <td class="border" style="font-weight:700;">42</td>
                                <td class="border" style="font-weight:700;">41</td>
                                <td class="border" style="font-weight:700;">31</td>
                                <td class="border" style="font-weight:700;">32</td>
                                <td class="border" style="font-weight:700;">33</td>
                                <td class="border" style="font-weight:700;">34</td>
                                <td class="border" style="font-weight:700;">35</td>
                                <td class="border" style="font-weight:700;">36</td>
                                <td class="border" style="font-weight:700;">37</td>
                                <td class="border" style="font-weight:700;">38</td>
                            </tr>
                            <tr>                             
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="47L" name="dental_issues[]" value="<?php echo isset($details[42]) ? $details[42] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="46L" name="dental_issues[]" value="<?php echo isset($details[43]) ? $details[43] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="45L" name="dental_issues[]" value="<?php echo isset($details[44]) ? $details[44] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="44L" name="dental_issues[]" value="<?php echo isset($details[45]) ? $details[45] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="43L" name="dental_issues[]" value="<?php echo isset($details[46]) ? $details[46] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="42L" name="dental_issues[]" value="<?php echo isset($details[47]) ? $details[47] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="41L" name="dental_issues[]" value="<?php echo isset($details[48]) ? $details[48] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="31L" name="dental_issues[]" value="<?php echo isset($details[49]) ? $details[49] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="32L" name="dental_issues[]" value="<?php echo isset($details[50]) ? $details[50] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="33L" name="dental_issues[]" value="<?php echo isset($details[51]) ? $details[51] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="34L" name="dental_issues[]" value="<?php echo isset($details[52]) ? $details[52] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="35L" name="dental_issues[]" value="<?php echo isset($details[53]) ? $details[53] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="36L" name="dental_issues[]" value="<?php echo isset($details[54]) ? $details[54] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="37L" name="dental_issues[]" value="<?php echo isset($details[55]) ? $details[55] : ''; ?>" readonly></td>  
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="38L" name="dental_issues[]" value="<?php echo isset($details[56]) ? $details[56] : ''; ?>" readonly></td>   
                                <td class="border" style="width: 50px;"><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black" toothId="48U" name="dental_issues[]" value="<?php echo isset($details[57]) ? $details[57] : ''; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="47U" name="dental_issues[]" value="<?php echo isset($details[58]) ? $details[58] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="46U" name="dental_issues[]" value="<?php echo isset($details[59]) ? $details[59] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="45U" name="dental_issues[]" value="<?php echo isset($details[60]) ? $details[60] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="44U" name="dental_issues[]" value="<?php echo isset($details[61]) ? $details[61] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="43U" name="dental_issues[]" value="<?php echo isset($details[62]) ? $details[62] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="42U" name="dental_issues[]" value="<?php echo isset($details[63]) ? $details[63] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="41U" name="dental_issues[]" value="<?php echo isset($details[64]) ? $details[64] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="31U" name="dental_issues[]" value="<?php echo isset($details[65]) ? $details[65] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="32U" name="dental_issues[]" value="<?php echo isset($details[66]) ? $details[66] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="33U" name="dental_issues[]" value="<?php echo isset($details[67]) ? $details[67] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="34U" name="dental_issues[]" value="<?php echo isset($details[68]) ? $details[68] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="35U" name="dental_issues[]" value="<?php echo isset($details[69]) ? $details[69] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="36U" name="dental_issues[]" value="<?php echo isset($details[70]) ? $details[70] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="37U" name="dental_issues[]" value="<?php echo isset($details[71]) ? $details[71] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="38U" name="dental_issues[]" value="<?php echo isset($details[72]) ? $details[72] : ''; ?>" readonly></td>
                                <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="85U" name="dental_issues[]" value="<?php echo isset($details[73]) ? $details[73] : ''; ?>" readonly></td>
                              </tr>
                              <tr>
                                <td colspan="3" style="border:none">Temporary Teeth</td>
                                <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/incisor.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/canine.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td class="border "><img src="{{asset('images/55-Teeth.png')}}" height="5" width="50" class="img-fluid" alt="Dashboard Ecommerce" /></td>
                                <td colspan="3" style="border:none"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="border:none;font-weight:700;">Right</td>
                                <td class="border" style="font-weight:700;">85</td>
                                <td class="border" style="font-weight:700;">84</td>
                                <td class="border" style="font-weight:700;">83</td>
                                <td class="border" style="font-weight:700;">82</td>
                                <td class="border" style="font-weight:700;">81</td>
                                <td class="border" style="font-weight:700;">71</td>
                                <td class="border" style="font-weight:700;">72</td>
                                <td class="border" style="font-weight:700;">73 </td>
                                <td class="border" style="font-weight:700;">74</td>
                                <td class="border" style="font-weight:700;">75</td>
                                <td colspan="3" style="border:none;font-weight:bold;">Left</td>
                            </tr>
                            <tr>
                              <td colspan="3" style="border:none">Status</td>
                              
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="84" name="dental_issues[]" value="<?php echo isset($details[74]) ? $details[74] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="83" name="dental_issues[]" value="<?php echo isset($details[75]) ? $details[75] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="82" name="dental_issues[]" value="<?php echo isset($details[76]) ? $details[76] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="81" name="dental_issues[]" value="<?php echo isset($details[77]) ? $details[77] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="71" name="dental_issues[]" value="<?php echo isset($details[78]) ? $details[78] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="72" name="dental_issues[]" value="<?php echo isset($details[79]) ? $details[79] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="73" name="dental_issues[]" value="<?php echo isset($details[80]) ? $details[80] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="74" name="dental_issues[]" value="<?php echo isset($details[81]) ? $details[81] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="75" name="dental_issues[]" value="<?php echo isset($details[82]) ? $details[82] : ''; ?>" readonly></td>
                              <td class="border" ><input type="text" class="" style="font-weight:700; width: 100%; height: 100%; border-radius: 0;text-align:center;background-color: rgb(185, 210, 248);color:black"  toothId="75" name="dental_issues[]" value="<?php echo isset($details[83]) ? $details[83] : ''; ?>" readonly></td>
                              <td colspan="3" style="border:none"></td>
                               </tr>
                        </thead>
                    </table>
                    <hr>
                    <h6 style="text-align:center;font-weight:bold">TREATMENT RECORD</h6>
                    <div style="text-align: right">
                    <div style="font-weight: 400; font-size: 12px;">
                        <label for="example-month-input" class="col-1 ">date<span class="text-danger">*</span></label>
                        <input class="form-control col-sm-3 date float-right @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" type="date" value="" id="date" name="date">
                    </div>
                </div>
                <div class="form-outline ">
                    <label class="form-label" for="textAreaExample" style="font-size: 12px">Chief Complain/Findings:<span class="text-danger">*</span></label>
                    <textarea class="form-control @error('treatment') is-invalid @enderror" name="treatment" value="{{ old('treatment') }}" required autocomplete="treatment"  id="treatment" rows="3"></textarea>
                </div>
                <div class="form-outline">
                    <label class="form-label" for="textAreaExample" style="font-size: 12px">Physiological Parameters:<span class="text-danger">*</span></label>
                    <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" value="{{ old('diagnosis') }}" required autocomplete="diagnosis" id="diagnosis" rows="3"></textarea>
                </div>
                <hr>
                <label for="cancer" style="text-transform: capitalize;font-size:14px;font-weight:bolder">Remarks:</label>
                    <div class="form-check" style="width: 50%">
                    <input type="checkbox" id="" name="remarks[]" value="Consultation">
                    <label for="cancer" style="text-transform: capitalize;font-size:12px;">Dental Check-up/ Consultation</label>
                    </div>
                    <div class="form-check" style="width: 50%">
                    <input type="checkbox" id="" name="remarks[]" value="Oral Restoration">
                    <label for="cancer" style="text-transform: capitalize;font-size:12px;">Cavity Filling/ Oral Restoration</label>
                    </div>
                    <div class="form-check" style="width: 50%">
                    <input type="checkbox" id="" name="remarks[]" value="Oral Prophylaxis">
                    <label for="cancer" style="text-transform: capitalize;font-size:12px;">Oral Prophylaxis</label>
                    </div>
                    <div class="form-check">
                    <input type="checkbox" id="" name="remarks[]" value="Tooth Extraction ">
                    <label for="cancer" style="text-transform: capitalize;font-size:12px;">Tooth Extraction</label>
                    </div>
                </div>
            </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
