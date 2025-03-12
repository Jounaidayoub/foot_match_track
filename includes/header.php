
<?php
// Notif Number calculation
// session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="header-style.css">
</head>
<body>
<style>
       
    @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

    *,*::after,*::before{
        margin:0;
        padding: 0;
        box-sizing: border-box;
    }
    :root{
        --pr-clr-l: #FFDF8A;
        --scnd-clr-l: #FFEFCA; 
        --black: #121211;
        --black-75: rgba(18,18, 17, 0.75);
        --black-50: rgba(18, 18, 17, 0.50);
        --input-back: #FFF9EB;
        --search-bar-back: white;
    } 
    :root{
        --nav-padd-right: 32px;
    }
    .nav{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 32px;
        position: sticky;
        top: 0;
        width: 100%;
        padding: 8px 32px;
        border-bottom: 1px solid #ccd1d6;
        z-index: 1000;
        background-color: white;
        padding-left: 32px !important;
    }
    /* the left navigation part */
    .nav-l{
        display: flex;
        align-items: center;
        gap:32px;
    }
    .icon-div{
        margin: auto auto auto 0;
        width: 120px;
        img{
            width: 100%;
        }
    }
    .icon-link{
        display: flex;
    }

    .links{
        list-style: none;
        text-decoration: none;
        display: flex;
        gap: 32px;
        align-items: center;
            margin-bottom: 0 !important;
        
    }
    .link{
        color: var(--black);
        font-size: 16px;
        font-family: Lato, sans-serif;
        font-weight: 700;
        text-decoration: none;
        transition: all ease 250ms ;
        li{
            list-style: none;
        }
    }
    .link:hover{
        color:#5f5f5c;
    }

    /* the right navigation part */
    .nav-r{
        display: flex;
        gap: 16px;
        align-items: center;
    }
    .search-div{
        display: flex;
        width: 220px;
        gap: 4px;
        border-radius: 35px;
        background-color: var(--search-bar-back);
        border: 2px solid #E8E8E8;
        transition: all ease 250ms;
    }
    .search-icon{
        width: 16px;
        margin: 16px 0 16px 16px;
    }
    .search-inpt{
        border: none;
        font-family: Lato, sans-serif;
        font-weight: 400;
        font-size: 16px;
        width: 100%;
        background-color: var(--search-bar-back);
        padding: 8px 8px 8px 8px;
        border-radius: 35px;
    }
    .search-inpt:focus{
        outline: none;
    }
    .search-div:hover, .profile-div:hover{
        -webkit-box-shadow: 0 0 0 4px var(--scnd-clr-l);
        box-shadow: 0 0 0 4px var(--scnd-clr-l);
    }
    /* .search-inpt:focus{
        -webkit-box-shadow: 0 0 0 4px var(--scnd-clr-l);
        box-shadow: 0 0 0 4px var(--scnd-clr-l);
    } */
    .profile-wraper{
        position: relative;
    }
    .profile-div{
        display: block;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        transition: all ease 250ms;

    }
    .profile-div img{
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }
    .auth-div{
        margin: 0 16px;
    }
    .custom-btn{
        font-family: Lato, sans-serif;
        padding: 8px 24px;
        border-radius: 35px;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        background: var(--pr-clr-l, #FFDF8A);
        border: none;
        transition: all ease 150ms;
    }
    .custom-btn:hover{
        background:  #f6d67f;
        transform: translateY(-3px);
        color: var(--black);
    }

    .profile-pop{
        padding: 1em 1em;
        background-color: white;
        border-radius: 14px;
        display: flex;
        flex-direction: column;
        gap: 1.5em;
        position: absolute;
        top: 65px;
        right: 0;
        transition: opacity 0.3s ease-in-out 0.15s, visibility 0.3s ease-in-out 0.15s, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) 0.45s, -webkit-transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) 0.45s;
        box-shadow:  0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -4px rgba(0,0,0,.1);
    }
    .pop{
        visibility: hidden;
        opacity: 0;
    }
    .profile-pop-info{
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: .8rem;
        font-weight: 600;
        margin: 1em 5em;
        margin-bottom: 0;
        width: 150px;
    text-overflow: hidden;
    overflow: hidden;
    font-family: Lato;

    }
    .profile-pop-info span{
        display: inline-block;
        width: inherit;
        text-align: center;
    }
    .profile-pop-info img{
        display: inline-block;
        margin-bottom: .5em;
        width: 90px;
        height: 90px;
        /* height: 100px; */
        border-radius: 50%;
    }
    .profile-pop-options{
        display: flex;
        flex-direction: column;
        align-items: start;
        gap: 1em;
        margin-left: 1em;
    }
    .profile-pop a{
        text-decoration: none;
        font-size: 1.05rem;
        font-weight: 500;
        color: black;
        font-family: Lato;
    }
    .profile-pop a:hover{
        color: rgb(77, 77, 77);
    }
    .profile-pop-signout{
        display: inline-block;
        border-top: 1px solid gainsboro;
        padding-top: 1em;
        padding-bottom: 1em;
        margin-left: 1em;
        font-size: 1.05rem;
        font-weight: 500;
        color: black;
        font-family: Lato;
    }

        .notification-bell {
            position: relative;
            display: inline-block;
            font-size: 24px;
        /* 	width: 28px; */	  
            cursor: pointer;
            border-radius: 14px;
            padding: 8px;
            }
        .notification-bell:hover{
            background-color: #9993;
        }
        .notification-bell img{
            display: flex;
            margin: auto;
            width: 28px;
        }
        .notification-bell .badge {
        /*   right: -7px; */
        background-color: red;
        color: white;
        position: absolute;
        top: 4px;
        /*   left: 12px; */
        display: inline-block;
        padding: 0 4px;
        /*   min-width: 8px; */
        /*   max-width: 18px; */
        height: 16px;
        border-radius: 22px;
        text-align: center;
        font-family: "Lato","Arial",sans-serif;
        font-size: 12px;
        font-weight: 400;
        line-height: 16px;
        right: 0;
        width: 20px;
        }
        .nav{
            z-index: 3000;
        }    
        .profile-div img, .profile-pop-info img{
            object-fit: cover;
        }
        #search-inpt:hover{
            box-shadow: none;
            -webkit-box-shadow: none;
        }
        #search-inpt:selection{
            box-shadow: none;
            -webkit-box-shadow: none;
        }
</style>
	
    <nav class="nav">
        <section class="nav-l">
            <div class="icon-div">
                <a href="home" class="icon-link">
                    <img src="assets/imgs/MG.svg" alt="icon">
                </a>
            </div>
            <ul class="links">
                <a href="home" class="link" >
                    Home
                </a>
                <a href="" class="link" >
                    Equipes
                </a>
                <a href="facultes" class="link" >
                    Matches
                </a>
                <a href="faq.jsp" class="link">
                    FAQ
                </a>
                <?php if(isset($_SESSION["role"]) && $_SESSION["role"] === 'g'):?>
                    <a href="../admin-general/team.php" class="link" >
                        Espace Admin
                    </a>
                <?php endif;?>
                <?php if(isset($_SESSION["role"]) && $_SESSION["role"] === 't'):?>
                    <a href="admint.php" class="link" >
                        Espace Admin
                    </a>
                <?php endif;?>
            </ul>
        </section>
        <section class="nav-r">
			<!--notification -->
            <?php if(isset($_SESSION["id"])) :?>
	            <a href="Notifications" class="notification-bell">
	                <img src=../assets/imgs/bell.svg alt="bell">
<!-- 	                
	                <%-- storing the notifications number  --%>
	                <% 
		                String token =(String) session.getAttribute("id");
		                int id = OraFactory.getUserDao().getEtudiantIdFromToken(token);
		                request.setAttribute("notifNum",OraFactory.getNotifDao().getNotReadedNotifNum( id ) ); 
	                
	                %> -->
                    <?php if(isset($notifNumber) && $notifNumber > 0) :?> 
		        		<span class="badge">
		        			${notifNum }
		        		</span> 
                    <?php endif;?>

	    		</a>

            <?php endif;?>
    		
            <form class="search-div" method="GET" action="search" id="search-form">
                <img src="../assets/imgs/search.svg" alt="search-bar" class="search-icon">
                <input type="text" name="search" id="search-inpt" class="search-inpt" placeholder="Search...">
                <input type="hidden" name="filter" value="masters">
            </form>
            <!--the profile icon -->
            <?php if(isset($_SESSION["id"])) :?>
	            <section class="profile-wraper">
	                <a href="Profile" class="profile-div ">
                        <img src="<?= isset($img)? $img: '../assets/imgs/user-circle.svg' ?>" alt="profile">
	                </a>
	                <div class="profile-pop pop">
	                    <div class="profile-pop-info">
                            <!-- https://api.dicebear.com/9.x/initials/svg?seed=Felix -->
	                        <img src="<?= isset($img)? $img: '../assets/imgs/user-circle.svg' ?>" alt="profile">
	                        <span class="profile-pop-name"><?= $_SESSION["nom"] ?></span>
	                        <span class="profile-pop-email"><?= $_SESSION["email"] ?></span>
	                    </div>
	                    <div class="profile-pop-options">
	                        <a href="Notifications">Notifications</a>
	                        <a href="Mymasters">Followed Teams</a>
	                    </div>
	                    <a href="../auth/signout.php" class="profile-pop-signout">Sign out</a>
	                </div>
	            </section>
            <?php endif;?>
	        
            <?php if(!isset($_SESSION["id"])) :?>
            <!-- signup and signin -->
	            <ul class="links auth-div">
	                <a href="../auth/auth.php" class="link">
	                    Sign In
	                </a>
	                <!-- <a href="Signup" class="link custom-btn">
	                    Sign Up
	                </a> -->
	            </ul>
            <?php endif;?>
        </section>
    </nav>


    <script>
        document.querySelector(".profile-div").addEventListener("mouseleave",()=>{
            document.querySelector(".profile-pop").classList.toggle("pop");
        })
        document.querySelector(".profile-div").addEventListener("mouseover",()=>{
            document.querySelector(".profile-pop").classList.toggle("pop");
        })
        document.querySelector(".profile-pop").addEventListener("mouseover",()=>{
            document.querySelector(".profile-pop").classList.remove("pop");
        })
        document.querySelector(".profile-pop").addEventListener("mouseleave",()=>{
            document.querySelector(".profile-pop").classList.add("pop");
        })
    </script>
    
        
</body>
</html>