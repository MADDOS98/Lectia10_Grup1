# Lectia6_Grup1

**Lectia 6 – Varianta Grupul 1**

---

## Avantaje și Limitări – Stil Procedural `mysqli`

### Avantajele Stilului Procedural (`mysqli`)

- **Simplitate și Claritate**  
  Ușor de învățat pentru începători, având o structură liniară și logică (apel de funcții).

- **Viteză**  
  Similar ca performanță cu stilul orientat obiecte `mysqli` (ambele sunt mai rapide decât vechea extensie `mysql`).

- **Potrivit pentru Scripturi Mici**  
  Excelent pentru scripturi simple și rapide, unde nu este necesară o structură complexă de programare orientată pe obiecte.

---

### Limitările Stilului Procedural (`mysqli`)

- **Mentenanță Dificilă (Scalabilitate)**  
  Pe măsură ce aplicația crește, codul devine mai greu de citit, de menținut și de depanat, lipsindu-i organizarea specifică POO.

- **Lipsa Conceptelor POO**  
  Nu beneficiază de concepte precum moștenirea, încapsularea sau abstractizarea, care ajută la crearea unui cod reutilizabil și robust.

- **Funcții cu Prefix (Verbose)**  
  Toate funcțiile încep cu prefixul `mysqli_` (ex: `mysqli_connect()`, `mysqli_query()`), ceea ce face numele funcțiilor mai lungi și repetitive decât în stilul POO.

- **Necesitatea Transmiterii Variabilei de Conexiune**  
  Variabila de conexiune (`$conn`) trebuie transmisă ca prim parametru la aproape fiecare apel de funcție (`mysqli_query($conn, $sql)`), spre deosebire de POO, unde conexiunea este încapsulată în obiect.

---