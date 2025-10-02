flowchart LR
    Start([Start]) --> Upload(Upload Assignments)
    Upload --> Validation{File Validation?}
    Validation -->|Yes| Store(Store File)
    Validation -->|No| Upload
    Store --> Extract(Extract File)
    Extract --> Preprocess(Preprocessing)
    Preprocess --> Calculate(Calculate Similiarity)
    Calculate --> StoreResults(Store Results)
    StoreResults --> Display(Display Results)
    Display --> Threshold{Above Threshold?}
    Threshold -->|Yes| Label(Label as Plagiarism)
    Threshold -->|No| End([End - Acceptable])
    Label --> End_Plagiarism([End - Plagiarism Detected])
