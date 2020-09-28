package main

import (
    "fmt"
    "os"
    "github.com/360EntSecGroup-Skylar/excelize"
    "database/sql"
    _ "github.com/go-sql-driver/mysql"
    "strings"
)

func main(){

    id := getArg()
    findMember(id)
//        getIdFromDb()

    //DB에서 해당 아이디로 검색한 회원이 있는지 확인

    //DB에 업데이트하는건 마지막에 회원가입이 완료된 후에 key-val, key: id, val : true or false




}

func MemberIdExists(id string) bool{
db, err := sql.Open("mysql", "root:f4g5h6j7k8!@/global_db_trade")
    if err != nil{
        panic(err.Error())
    }
    defer db.Close()

    err = db.Ping()
    if err != nil{
        panic(err.Error())
    }

    rows, err := db.Query("SELECT * FROM g5_member where mb_no = " + id)
    	if err != nil {
    		panic(err.Error()) // proper error handling instead of panic in your app
    	}

    	// Get column names
    	columns, err := rows.Columns()
    	if err != nil {
    		panic(err.Error()) // proper error handling instead of panic in your app
    	}

    	// Make a slice for the values
    	values := make([]sql.RawBytes, len(columns))

    	// rows.Scan wants '[]interface{}' as an argument, so we must copy the
    	// references into such a slice
    	// See http://code.google.com/p/go-wiki/wiki/InterfaceSlice for details
    	scanArgs := make([]interface{}, len(values))
    	for i := range values {
    		scanArgs[i] = &values[i]
    	}


    	// Fetch rows
    	for rows.Next() {
    		// get RawBytes from data
    		err = rows.Scan(scanArgs...)
    		if err != nil {
    			panic(err.Error()) // proper error handling instead of panic in your app
    		}

    		// Now do something with the data.
    		// Here we just print each column as a string.
    		var value string
    		for i, col := range values {
    			// Here we can check if the value is nil (NULL value)
    			if col == nil {
    				value = "NULL"
    			} else {
    				value = string(col)
    			}
    			fmt.Println(columns[i], ": ", value)
    		}
    		fmt.Println("-----------------------------------")
    	}
    	if err = rows.Err(); err != nil {
    		panic(err.Error()) // proper error handling instead of panic in your app
    	}

    	return true
}

func getArg() string{

    arg := os.Args[1]

    if len(os.Args) < 2 {
        panic("need id")
    }

    return arg
}

func findMember(id string){
    f, err := excelize.OpenFile("/var/www/html/go/members_code.xlsx");
    if err != nil {
        fmt.Println(err.Error())
        return
    }
    str := f.SearchSheet("회원가입_사원코드 정리", id)
    if len(str) > 0 && strings.Contains(id, "SNP") {
        fmt.Println(f.GetCellValue("회원가입_사원코드 정리", "C"+str[0][1:])+"/"+f.GetCellValue("회원가입_사원코드 정리", "D"+str[0][1:])+"/"+f.GetCellValue("회원가입_사원코드 정리", "E"+str[0][1:]))
		//cellValue := f.GetCellValue("회원가입_사원코드 정리", str[0])
        //fmt.Println(cellValue)
//         if f.GetCellValue("회원가입_사원코드 정리", "C"+str[0][1:]) == "김제술"{
//             fmt.Println("찾음")
//         }

//         fmt.Println(cellValue)
    }else{
        fmt.Println("")
    }

}