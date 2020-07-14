joint 

 update sirhcp.employer,sirhcp1.employer set sirhcp.employer.type_employe=sirhcp1.employer.type_employe where sirhcp.employer.id_employe=sirhcp1.employer.id_employe
 
 select * from sirhcp1.employer where sirhcp1.employer.id_employe NOT IN (select sirhcp.employer.id_employe from sirhcp.employer)//