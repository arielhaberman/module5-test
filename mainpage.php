<!DOCTYPE html> 
<html lang="en">
<head>
    <title>My Calendar</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>


<body>

    <button type="button" id="prev_month_btn">
        Previous Month
    </button>
    <button type="button" id="next_month_btn">
        Next Month
    </button>

    <div id="days"></div>
    
    <div id="sidebar" >
        <?php    

        require 'database.php';
        session_start();
        
        $username = $_SESSION['username'];
        if ($_SESSION["registered"] == TRUE) {
            echo "<b> $username </b>";
            echo "<br><br>";
            echo "<a class='blacklink' href='logout.php'>Logout</a> <br><br>";
        }
        else {
            echo "<b>Guest</b> <br><br>"; 
            echo "<a class='blacklink' href='login.php'>Login</a> <br><br>";
            echo "<a class='blacklink' href='newUser.php'>Create an Account</a> <br><br>";
        }
        
        ?>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p style="color:white;">TEST</p>
    <script>
        (function(){Date.prototype.deltaDays=function(c){
            return new Date(this.getFullYear(),this.getMonth(),this.getDate()+c)
        };
        Date.prototype.getSunday=function(){
            return this.deltaDays(-1*this.getDay())}
        })();

        function Week(c){
            this.sunday=c.getSunday();
            this.nextWeek=function(){
                return new Week(this.sunday.deltaDays(7))};
            this.prevWeek=function(){return new Week(this.sunday.deltaDays(-7))};
            this.contains=function(b){return this.sunday.valueOf()===b.getSunday().valueOf()};
            this.getDates=function(){for(var b=[],a=0;7>a;a++)b.push(this.sunday.deltaDays(a));return b}
        }

        function Month(c,b){
            this.year=c;
            this.month=b;
            this.nextMonth=function(){
                return new Month(c+Math.floor((b+1)/12),(b+1)%12)
            };
            this.prevMonth=function(){
                return new Month(c+Math.floor((b-1)/12),(b+11)%12)
            };
            this.getDateObject=function(a){
                return new Date(this.year,this.month,a)
            };
            this.getWeeks=function(){
                var a=this.getDateObject(1),b=this.nextMonth().getDateObject(0),c=[],a=new Week(a);
                for(c.push(a);!a.contains(b);)a=a.nextWeek(),c.push(a);
                return c
            }
        };
    

        // For our purposes, we can keep the current month in a variable in the global scope
        var currentMonth = new Month(2020, 10); // November 2020

        // This updateCalendar() function only alerts the dates in the currently specified month.  You need to write
        // it to modify the DOM (optionally using jQuery) to display the days and weeks in the current month.
        function updateCalendar(){
            var dayArray = [];
            var weeks = currentMonth.getWeeks();
            
            for(var w in weeks){
                var days = weeks[w].getDates();
                // days contains normal JavaScript Date objects.
                
                
                for(var d in days){
                    dayArray.push(days[d]);
                    // You can see console.log() output in your JavaScript debugging tool, like Firebug,
                    // WebWit Inspector, or Dragonfly.
                    console.log(days[d].toISOString());
                }
            }

            document.getElementById("days").textContent = dayArray;
        }

        

        function nextMonth() {
            currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()
            updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
        }

        function prevMonth() {
            currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
            updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
        }

        //Change the month when the "next" button is pressed
        document.getElementById("next_month_btn").addEventListener("click", nextMonth, false);
        document.getElementById("prev_month_btn").addEventListener("click", prevMonth, false);
        document.addEventListener("DOMContentLoaded", updateCalendar, false);
    </script>


</body>

</html>
