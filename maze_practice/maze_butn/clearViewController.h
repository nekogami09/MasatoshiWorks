//
//  clearViewController.h
//  maze_butn
//
//  Created by g-2015 on 2013/08/20.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface clearViewController : UIViewController{
    //int _clearRemainingTime;
    
}

@property int clearRemainingTime;
@property (weak, nonatomic) IBOutlet UILabel *clearRemainingTimeView;

@end
