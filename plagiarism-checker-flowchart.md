```mermaid
flowchart LR
    Start --> Check_If_Plagiarized
    Check_If_Plagiarized -->|Yes| Notify_Author
    Check_If_Plagiarized -->|No| End
    Notify_Author --> Review_Case
    Review_Case -->|Action Taken| End
    Review_Case -->|No Action| End
    End --> Finish
    Finish -->|Complete| Done
```