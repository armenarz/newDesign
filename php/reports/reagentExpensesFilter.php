<?php
    if(sizeof($reagentIdArr) == 0)
    {
        if(     $doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно)</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально)</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544')";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."'";
            }
            
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544')";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."'";
            }
            
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.user_id='".$userId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orders.user_id='".$userId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        ///////////////////////////////////////////////////////////////////////////////////////
        else if($doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck)</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck)</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
    }
    else
    {
        $reagentIdArrText = implode(",",$reagentIdArr);
        if(     $doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck == 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.")";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        ///////////////////////////////////////////////////////////////////
        else if($doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId == 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId == 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId == 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId == 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            if($salesId == 2 || $salesId == 4 || $salesId == 16)
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND (doctor.sales_id='".$salesId."' OR orders.DoctorId='1188' OR orders.DoctorId='1544') AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            else
            {
                $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            }
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
        else if($doctorId != 0 && $workplaceId != 0 && $salesId != 0 && $userId != 0 && $doubleCheck != 0)
        {
            $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.DoctorId='".$doctorId."' AND Doctor.WorkPlaceId='".$workplaceId."' AND doctor.sales_id='".$salesId."' AND orders.user_id='".$userId."' AND orderresult.ReagentId IN(".$reagentIdArrText.") AND orderresult.double_check='".$doubleCheck."'";
            
            if($reportTypeId == 1)
            {
                $reportDescription = "<span>(тип отчета: суммарно, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";    
            }
            else if($reportTypeId == 2)
            {
                $reportDescription = "<span>(тип отчета: детально, только DoubleCheck, по реагентам [ id: ".$reagentIdArrText." ], по доктору: ".$doctorName." [ id: ".$doctorId." ], по месту работы: ".$workplace." [ id: ".$workplaceId." ], по sales: ".$sales." [ id: ".$salesId." ], по пользователю: ".$user." [ id: ".$userId." ])</span>";
            }
        }
    }
?>