###Branching model (release model)

1. We use the branching model found here: http://nvie.com/posts/a-successful-git-branching-model/
1. Always branch new features off the develop branch `git checkout -b [featureBranchName]`
    1. featureBranchName should start with the issue number and be as short as possible (e.g. 999-example-name)
1. Commit your changes to the feature branch
    - Always include the issue number at the begining of the commit message
    - e.g. `git commit -m '#111 made some changes'`
1. Ensure that your branch has no linting errors
1. Push your changes to this repo
1. Create a **pull request** from your feature branch to the **develop** branch
    - The title of your pull request should match the title of the task you're completing
    - Include a link to the trello card in the description
    - Include a gif of your changes. Use [licecap](http://www.cockos.com/licecap/) if you need software.
        - If your changes are difficult to include into one GIF, make two.
    - Provide a summary of the work you completed in the description of the pull request.
    - Add steps to QA so the reviewer can quickly know what changed and why
1. Review the "diff" of your code
    - Make sure all changes are needed and wanted.
    - Comment to explain any unusual code.
    - Clean up code.
1. Your changes will be merged after QA

###Branching model (continuous deployment)

1. Always make a feature branch off `master` using a ticket number and short description (e.g. `99-new-feature`)
1. Commit changes using the ticket number (e.g. `#99 - added some stuff for new feature`)
  1. Notice that the ticket number is included first in the commit message
1. Create a pull request to merge to the `develop` branch
    - The title of your pull request should match the title of the task you're completing
    - Include a link to the item ticket the description
    - Include a gif of your changes. Use [licecap](http://www.cockos.com/licecap/) if you need software.
        - If your changes are difficult to include into one GIF, make two.
    - Provide a summary of the work you completed in the description of the pull request.
    - Add steps to QA so the reviewer can quickly know what changed and why
1. If there are merge conflicts, create a branch with a DEV prefix (e.g. `DEV-99-new-feature
    - merge in the `develop` branch and resolve the conflict
    - Note: NEVER merge develop into a branch that doesn't have DEV in front of it
1. Review the "diff" of your code
    - Make sure all changes are needed and wanted.
    - Comment to explain any unusual code.
    - Clean up code.
1. Request a review from the developer lead