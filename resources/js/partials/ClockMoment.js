import moment from "moment";
export default function clock() {

    $(function () {
        let hari = {
            "Sunday": "Minggu",
            "Monday": "Senin",
            "Tuesday": "Selasa",
            "Wednesday": "Rabu",
            "Thursday": "Kamis",
            "Friday": "Jumat",
            "Saturday": "Sabtu",
        }
        function times() {
            let now = moment();
            let day = now.format('dddd');
            let convertDays = hari[day];
            let jam = now.format('HH:mm:ss');
            $("#clock").html(`${jam}`);
            $("#dates").html(`${convertDays}, ${now.format('DD/MM/YYYY')}`);
        }
        setInterval(times, 1000);
        times();
    })
}
