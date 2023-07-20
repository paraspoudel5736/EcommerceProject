function opr(choice)
{

    val1=parseFloat(document.getElementById("val1").value)
    val2=parseFloat(document.getElementById("val2").value)
    switch(choice){
        case 'add':
            document.getElementById("result").value=val1+val2
            break

            case 'sub':
                document.getElementById("result").value=val1-val2
                break

                case 'mul':
                    document.getElementById("result").value=val1*val2

               break
               
               case 'div':
                document.getElementById("result").value=val1/val2
                break
    }
}