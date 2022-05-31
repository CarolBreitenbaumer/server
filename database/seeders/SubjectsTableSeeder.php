<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject1 = new Subject();
        $subject1->description = "Webanwendungen können auf Benutzerinteraktion reagieren und können ein dynamisches Verhalten aufweisen, wenn Sie eine Programmiersprache außer Hypertext Markup Language (HTML) verwenden. Es gibt zwei Arten der Programmierung in Webanwendungen: Clientseitige und serverseitige Programmierung.
                    Clientseitige Programmierung bedeutet die Verwendung einer Programmiersprache, die vom Web-Browser des Benutzers ausgeführt wird. Die bei Weitem am häufigsten verwendete Programmiersprache für clientseitige Programmierung ist JavaScript. JavaScript kann in separate Textdateien aufgenommen werden, die von den HTML-Dateien referenziert werden, oder Sie können es direkt in die HMTL in spezielle HTML-Tags, sogenannte scripttags, stellen. Wenn der Web-Browser des Benutzers auf diese Script-Tags trifft, führt er den in diesen Tags oder Dateien enthaltenen JavaScript-Code aus.
                    Asynchronous JavaScript + XML (Ajax) ist ein Begriff, mit dem eine spezielle Verwendung der JavaScript-Codierung definiert wird. Sie können mit JavaScript-Code eine HTML-Anforderung an eine URL stellen und mit der Antwort etwas machen, sie z. B. einem Benutzer zeigen oder sie verarbeiten. Die Antwort ist oft in gültigem XML, das von JavaScript-Komponenten leicht syntaktisch analysiert werden kann. Mit Ajax können Webanwendungen Informationen für den Benutzer abrufen, ohne dass die Webseite, die der Benutzer gerade anschaut, aktualisiert werden muss. Dieses Verhalten wird vom Benutzer als angenehm und flüssig erfahren und Sie haben die Möglichkeit, Webanwendungen mit mehr Informationsgehalt zu erstellen.
                    Serverseitige Programmierung bezieht sich auf die Verwendung von Maschinensprachen, um Code zu schreiben und ihn auf dem Web-Server auszuführen. Diese Ausführung findet statt, nachdem ein Benutzer mittels einer URL eine Anforderung gestellt hat und bevor die Web-Server-Software die HTML zum Web-Browser des Benutzers zurückschickt. Webanwendungen mit serverseitiger Programmierung greifen oft auf eine Datenbank oder auf Dateien auf dem Web-Server zu. Beispiele für Webanwendungen, die umfangreiche serverseitige Programmierung verwenden, sind E-Commerce-Sites, Social Networking-Sites und Wikis.
                    Quelle: <a>https://www.ibm.com/docs/de/i/7.4?topic=serving-programming</a>";
        $subject1->name = "Clientseitige Programmierung";


        $subject2 = new Subject();
        $subject2->description = "Der „große Sinn von CSS“ besteht in der Trennung von Inhalt und Design. Das hört man oft, stellt sich nichts drunter vor und bastelt dann doch eine besondere Überschrift mit einem inline-style, einen neuen div-Container mit einer ganz speziellen ID oder Klasse, die später nirgends wieder auftaucht. Das funktioniert auch mehr oder weniger – man wird ohne viel Mühe eine statische Seite zusammenstellen, die ihren Zweck erfüllt – und vergisst das ganze.
                    Es ist aber beinahe unmöglich, einen so über die Zeit gewucherten Internetauftritt umzugestalten – man müsste dutzende oder mehr Einzeldateien umschreiben und im Gewusel der Klassen und Elemente wird man sich schnell verlieren. Letztlich dauert die Änderung beinahe länger als eine Neuerstellung.
                    Und genau darin liegt die Stärke von CSS: uneingeschränkte Flexibilität, wenn z. B. das Layout nicht mehr zeitgemäß ist oder neue Strukturen, vor allem bei dynamischen Seiten, Änderungen erfordern. Dabei wäre man ohne CSS buchstäblich „verloren im Quelltext“.
                    <a>https://wiki.selfhtml.org/wiki/CSS/Tutorials/Einstieg/Stylesheets_einbinden</a>";
        $subject2->name = "CSS";


        //wegen Belongs To Beziehung
        //speichern Tutor zu Fach
        $tutor = Tutor::all()->first();
        $subject1->tutor()->associate($tutor);
        $subject1->save();

        $subject2->tutor()->associate($tutor);
        $subject2->save();



    }
}
