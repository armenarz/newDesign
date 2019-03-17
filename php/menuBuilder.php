<?php
require_once("connect.php");
//MenuItem դասը (class-ը) նախատեսված է մենյուների տողի (navbar-ի)մեջ 
//ներառված առանձին մենյուների վերաբերյալ տեղեկատվության պահպանման համար:
//Այս դասի յուրաքանչյուր օրինակի դաշտերի արժեքները 
//ստացվում են տվյալների բազայից:

class MenuItem
{
	//մենյուի (MenuItem-ի) հերթական համարը (համապատասխանում է user_menus աղյուսակում ներառված մենյուների հերթական համարին)
	private $id;				
	//օգտագործողի համարը (համապատասխանում է us22 աղյուսակում ներառված օգտագործողների հերթական համարին)
	private $userId;			
	//մենյուի անվանման համարը (համապատասխանում է մենյուների անվանումների menus աղյուսակում ներառված մենյուների հերթական համարին)
	private $menuId;			
	//մենյուի անվանումը (համապատասխանում է menus աղյուսակում ներառված մենյուների անվանմանը)
	private $menuName;			
	//մենյուի նկարագրությունը (համապատասխանում է menus աղյուսակում ներառված մենյուների նկարագրությանը)
	private $menuDescription;	
	//մենյուին ասոցացվող php ֆայլի ճանապարհը
	private $phpFilePath;		
	//վերադաս մենյուի համարը, եթե մենյուն հանդիսանում է ենթամենյու
	private $parentMenuId;		
	//մենյուի դասավորման հերթական համարը
	private $sortOrder;			
	//ենթամենյու լինելու կարգավիճակը
	private $isSubmenu;			
	public function __construct($id,$userId,$menuId,$menuName,$menuDescription,$phpFilePath,$parentMenuId,$sortOrder)
	{
		$this->id = $id;
		$this->userId = $userId;
		$this->menuId = $menuId;
		$this->menuName = $menuName;
		$this->menuDescription = $menuDescription;
		$this->phpFilePath = $phpFilePath;
		$this->parentMenuId = $parentMenuId;
		if($this->parentMenuId > 0)$this->isSubmenu = TRUE;
		$this->sortOrder = $sortOrder;
	}
	//վերադարձնում է մենյուի հերթական համարը
	public function Id()
	{
		return $this->id;	
	}
	//վերադարձնում է օգտագործողի հերթական համարը
	public function UserId()
	{
		return $this->userId;
	}
	//վերադարձնում է մենյուի անվանման հերթական համարը
	public function MenuId()
	{
		return $this->menuId;
	}
	//վերադարձնում է մենյուի անվանումը
	public function MenuName()
	{
		return $this->menuName;
	}
	//վերադարձնում է մենյուի նկարագրությունը
	public function MenuDescription()
	{
		return $this->menuDescription;
	}
	//վերադարձնում է մենյուին ասոցացվող ֆայլի ճանապարհը և անվանումը
	public function PhpFilePath()
	{
		return $this->phpFilePath;
	}
	//վերադարձնում է վերադաս մենյուի հերթական համարը
	public function ParentMenuId()
	{
		return $this->parentMenuId;
	}
	//վերադարձնում է մենյուի դասավորման հերթական համարը
	public function SortOrder()
	{
		return $this->sortOrder;
	}
	//վերադարձնում է ենթամենյու լինելու կարգավիճակը
	public function IsSubmenu()
	{
		return $this->isSubmenu;
	}
}
//MenuBuilder դասը (class-ը) նախատեսված է bootstrap 4 տեխնոլոգիայի վրա հիմնված
//կառուցվող nav տեսակի մենյուների տողի կառուցման համար;
//Մենյուների տողը կառուցելու համար այն տեղեկատվությունը ստանում է բազայի 
//menus և user_menus աղյուսակներից: Տվյալների բազայի menus աղյուսակում պահվում են
//համակարգում առկա բոլոր տեսակի մենյուների տվյալները ըստ կոդերի և անվանումների,
//այդ թվում մենյուների բաժանիչներին (divider) որպես անանուն մենյու տրվել է id=1 կոդը:
//Տվյալների բազայի user_menus աղյուսակում պահվում են համակարգում առկա բոլոր 
//մենյուների տվյալները ըստ օգտագործողների:
class MenuBuilder
{
	//մենյուին ասոցացվող php ֆայլի անվանումը
	private $phpSelf;
	//զանգված վերադաս մենյուների MenuItem դասի (class-ի) օրինակների պահպանման համար
	private $menuItems = array();
	//զանգված ենթամենյուների MenuItem դասի (class-ի) օրինակների պահպանման համար
	private $subMenuItems = array();
	//մենյուի HTML նշագրումը
	private $menuHTML;
	public function __construct($user,$phpSelf,$link)
	{
		$this->phpSelf = $phpSelf;
				
		$sql = "SELECT ";
		$sql.= 		"user_menus.id, ";
		$sql.=		"user_menus.userId, ";
		$sql.=		"user_menus.menuId, ";
		$sql.=		"menus.menuName, ";
		$sql.=		"menus.menuDescription, ";
		$sql.=		"user_menus.phpFilePath, ";
		$sql.=		"user_menus.parentMenuId, ";
		$sql.=		"user_menus.sortOrder ";
		$sql.= "FROM user_menus ";
		$sql.= "INNER JOIN menus ";
		$sql.= "ON user_menus.menuId = menus.menuId ";
		$sql.= "WHERE user_menus.userId=".$user." ";
		$sql.= "ORDER BY user_menus.sortOrder";
		$result = mysqli_query($link,$sql);
		if($result)
		{
			while($row = mysqli_fetch_array($result))
			{
				$tempMenuItem = new MenuItem(	$row["id"],
												$user,
												$row["menuId"],
												$row["menuName"],
												$row["menuDescription"],
												$row["phpFilePath"],
												$row["parentMenuId"],
												$row["sortOrder"]);
				if($tempMenuItem->IsSubmenu())
				{
					array_push($this->subMenuItems,$tempMenuItem);
				}
				else
				{
					array_push($this->menuItems,$tempMenuItem);
				}
				
			}
		}
	}
	//Վերադարձնում է նշված id-ով մենյուի ենթամենյուներ պարունակելու կարգավիճակը
	public function IsDropdownMenu($id)
	{
		for($i = 0; $i < count($this->subMenuItems); $i++)
		{
			if($id == $this->subMenuItems[$i]->ParentMenuId())
			{
				return TRUE;
			}
		}
		return FALSE;
	}
	//Վերադարձնում է նշված id-ով ենթամենյուի բաժանիչ(divider) լինելու կարգավիճակը
	public function IsDivider($id)
	{
		for($i = 0; $i < count($this->subMenuItems); $i++)
		{
			if($id == $this->subMenuItems[$i]->Id())
			{
				if($this->subMenuItems[$i]->MenuId() == 1) return TRUE;
			}
		}
		return FALSE;
	}
	public function IsLogout($id)
	{
		for($i = 0; $i < count($this->menuItems);$i++)
		{
			if($this->menuItems[$i]->Id()==$id)
			{
				if($this->menuItems[$i]->MenuId()==23)return TRUE;
			}
		}
		return FALSE;
	}
	//վերադարձնում է մենյուի HTML նշագրումը
	public function MenuHTML()
	{
		$menuHTML = '';
		$menuHTML.= $this->MenuHeaderHTML();
		$menuHTML.= $this->MenuBodyHTML();
		$menuHTML.= $this->MenuFooterHTML();
		return $menuHTML;
	}
	//վերադարձնում է մենյուների ընդհանուր նշագրի գլխագիրը(header)՝ սկզբնական մասը
	public function MenuHeaderHTML($brandName="",$brandHref="")
	{
		$menuHeaderHTML = '';
		$menuHeaderHTML.= '<nav class="navbar navbar-expand-lg">';//navbar-expand-lg navbar-light bg-light
  		$menuHeaderHTML.= 	'<a class="navbar-brand" href="#'.$brandHref.'">'.$brandName.'</a>';
  		$menuHeaderHTML.= 	'<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
    	$menuHeaderHTML.= 		'<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>';
  		$menuHeaderHTML.=	'</button>';
  		$menuHeaderHTML.=	'<div class="collapse navbar-collapse" id="navbarSupportedContent">';
  		return $menuHeaderHTML;
	}
	//վերադարձնում է մեկ մենյուի նշագրումը
	public function MenuItemHTML($id)
	{
		$menuItemHTML = '';
		$tempMenuItem = NULL;

		for($i = 0; $i < count($this->menuItems); $i++)
		{
			if($this->menuItems[$i]->Id() == $id)
			{
				$tempMenuItem = $this->menuItems[$i];
			}
		}
		if($tempMenuItem != NULL)
		{
			if($this->IsDropdownMenu($id))
			{
				$tempSubMenuItem = NULL;
				if($this->phpSelf != $tempMenuItem->PhpFilePath())
				{
					$menuItemHTML.=		'<li class="nav-item dropdown">';
	        		$menuItemHTML.=			'<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
	        		$menuItemHTML.=				$tempMenuItem->MenuName();
	        		$menuItemHTML.=			'</a>';
	        		$menuItemHTML.=			'<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
	        		for($i = 0; $i < count($this->subMenuItems); $i++)
	        		{
	        			$tempSubMenuItem = $this->subMenuItems[$i];
						if($tempSubMenuItem->ParentMenuId() == $id)
						{
							if($this->IsDivider($tempSubMenuItem->Id()))
							{
								$menuItemHTML.=		'<div class="dropdown-divider"></div>';
							}
							else
							{
								$menuItemHTML.=		'<a id="userMenu_'.$tempSubMenuItem->Id().'" class="dropdown-item" href="#">'.$tempSubMenuItem->MenuName().'</a>';
								//$menuItemHTML.=		'<a id="userMenu_'.$tempSubMenuItem->Id().'" class="dropdown-item" href="#" onclick="'.$tempSubMenuItem->Handler().'">'.$tempSubMenuItem->MenuName().'</a>';
							}	
						}
					}
	        		$menuItemHTML.=			'</div>';
	      			$menuItemHTML.=		'</li>';
				}
			}
			else
			{
				// $menuItemHTML.= 	'<li class="nav-item active">';
				if($this->phpSelf == $tempMenuItem->PhpFilePath())
				{
					$menuItemHTML.= 	'<li class="nav-item active">';
					$menuItemHTML.=		 	'<a id="userMenu_'.$tempMenuItem->Id().'" class="nav-link" href="#">'.$tempMenuItem->MenuName().'<span class="sr-only">(current)</span></a>';
					//$menuItemHTML.=		 	'<a id="userMenu_'.$tempMenuItem->Id().'" class="nav-link" href="#" onclick="'.$tempMenuItem->Handler().';">'.$tempMenuItem->MenuName().'<span class="sr-only">(current)</span></a>';
				}
				else
				{	
					$menuItemHTML.= 	'<li class="nav-item">';
					if($this->IsLogout($tempMenuItem->Id()))
					{
						$menuItemHTML.=			'<a id="userMenu_'.$tempMenuItem->Id().'" class="nav-link logout" href="#">'.$tempMenuItem->MenuName().'</a>';
						//$menuItemHTML.=			'<a id="userMenu_'.$tempMenuItem->Id().'" class="nav-link logout" href="#" onclick="'.$tempMenuItem->Handler().';">'.$tempMenuItem->MenuName().'</a>';
					}
					else
					{	
						$menuItemHTML.=			'<a id="userMenu_'.$tempMenuItem->Id().'" class="nav-link" href="#">'.$tempMenuItem->MenuName().'</a>';
						//$menuItemHTML.=			'<a id="userMenu_'.$tempMenuItem->Id().'" class="nav-link" href="#" onclick="'.$tempMenuItem->Handler().';">'.$tempMenuItem->MenuName().'</a>';
					}
				}
				$menuItemHTML.=		'</li>';
			}
		}
		return $menuItemHTML;
	}
	//վերադարձնում է մենյուների ընդհանուր նշագրի մարմինը
	public function MenuBodyHTML()
	{
		$menuBodyHTML = '';
		$menuBodyHTML.= '<ul class="navbar-nav mr-auto">';
		for($i = 0; $i < count($this->menuItems); $i++)
		{
			$menuBodyHTML.= $this->MenuItemHTML($this->menuItems[$i]->Id());
		}

    	$menuBodyHTML.=	'</ul>';
    	return $menuBodyHTML;
	}
	//վերադարձնում է մենյուների ընդհանուր վերջնական մասը
	public function MenuFooterHTML()
	{
		$menuFooterHTML = '';
		$menuFooterHTML.=	'</div>';
		$menuFooterHTML.= '</nav>';
		return $menuFooterHTML;
	}
}

$temp = new MenuBuilder($userId,$_SERVER["PHP_SELF"],$link);
echo $temp->MenuHTML();
?>